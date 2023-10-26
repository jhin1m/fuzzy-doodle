<?php

namespace App\Helpers;

use App\Models\Manga;
use App\Models\Taxable;
use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MangaHelper
{
  /**
   * Upload and process a cover image.
   *
   * @param \Illuminate\Http\UploadedFile|null $file The cover image file to be uploaded and processed.
   * @param int|null $mangaId The ID of the manga (optional, used for updating).
   * @param string|null $oldCover The name of the old cover image (optional, used for updating).
   * @return string|void The generated cover image name, or void if no action is taken.
   */
  public static function uploadAndProcessCover($file = null, $mangaId = null, $oldCover = null)
  {
    if ($file) {
      $coverName = self::processCoverImage($file);

      // Delete old cover on update
      if ($file && $oldCover) {
        self::deleteOldCover($mangaId, $oldCover);
      }

      return $coverName;
    } else {
      if ($mangaId) {
        return $oldCover;
      }
    }
  }

  /**
   * Process and store a cover image.
   *
   * @param \Illuminate\Http\UploadedFile $file The cover image file to be processed.
   * @return string The generated cover image name.
   */
  private static function processCoverImage($file)
  {
    if (settings()->get("image-encoding")) {
      $extension = settings()->get("extension") == "same" ? $file->getClientOriginalExtension() : settings()->get("extension");
      $coverName = uniqid() . "." . $extension;

      $img = Image::make($file)
        ->resize(500, null, function ($constraint) {
          $constraint->aspectRatio();
        })
        ->encode($extension, settings()->get("quality"));

      Storage::put("/public/covers/" . $coverName, $img);
    } else {
      $coverFile = $file;
      $coverName = uniqid() . "." . $coverFile->getClientOriginalExtension();
      $coverFile->storeAs("public/covers", $coverName);
    }

    return $coverName;
  }

  /**
   * Delete the old cover image.
   *
   * @param int $mangaId The ID of the manga.
   * @param string $oldCover The name of the old cover image.
   * @return void
   */
  private static function deleteOldCover($mangaId, $oldCover)
  {
    $manga = Manga::findOrFail($mangaId);
    Storage::delete("/public/covers/" . $oldCover);
  }

  /**
   * Attach genres to a manga.
   *
   * @param array $genres An array of genre strings to be attached.
   * @param int $id The ID of the manga to attach genres to.
   * @return void
   */
  public static function attachGenres($genres, $id)
  {
    if (!$genres) {
      return;
    }

    $manga = Manga::findOrFail($id);

    $genreIds = [];
    foreach ($genres as $genre) {
      $genre = trim($genre);
      if ($genre) {
        $slug = Str::slug($genre, "-");

        $existingGenre = Taxonomy::where("title", $genre)
          ->where("type", "genre")
          ->first();

        if (!$existingGenre) {
          $existingGenre = Taxonomy::create(["title" => $genre, "slug" => $slug, "type" => "genre"]);
        }

        $genreIds[] = $existingGenre->id;
      }
    }

    $manga->genres()->sync($genreIds);
  }

  /**
   * Attach a taxonomy to a manga.
   *
   * @param string $type The type of the taxonomy.
   * @param int $taxonomyId The ID of the taxonomy to attach.
   * @param int $mangaId The ID of the manga to attach the taxonomy to.
   * @return \Illuminate\Http\RedirectResponse|null
   */
  public static function attachTaxonomy($type, $taxonomyId, $mangaId)
  {
    if ($taxonomyId) {
      $manga = Manga::findOrFail($mangaId);
      $status = Taxonomy::where("type", $type)
        ->where("id", $taxonomyId)
        ->first();

      if (!$status) {
        return back()->with("error", __("Invalid status provided."));
      }

      // Remove previous taxonomy of the same type and ID
      Taxable::where("taxable_type", Manga::class)
        ->where("taxable_id", $mangaId)
        ->where("taxonomy_id", $taxonomyId)
        ->delete();

      Taxable::create(["taxonomy_id" => $taxonomyId, "taxable_type" => Manga::class, "taxable_id" => $mangaId]);
    }
  }

  public static function renameContentFolder($oldSlug, $newSlug)
  {
    $oldFolderPath = "public/content/$oldSlug";
    $newFolderPath = "public/content/$newSlug";

    if (Storage::exists($oldFolderPath)) {
      Storage::move($oldFolderPath, $newFolderPath);
    }
  }
}
