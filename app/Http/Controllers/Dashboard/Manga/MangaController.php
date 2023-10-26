<?php

namespace App\Http\Controllers\Dashboard\Manga;

use Exception;
use App\Models\View;
use App\Models\Manga;
use App\Models\Slider;
use App\Models\Comment;
use App\Helpers\CacheHelper;
use App\Helpers\MangaHelper;
use Illuminate\Http\Request;
use App\Helpers\SliderHelper;
use App\Helpers\ChapterHelper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    $this->middleware("can:viewAny," . Manga::class)->only("index");
    $this->middleware("can:create," . Manga::class)->only(["create", "store"]);
    $this->middleware("can:update,manga")->only(["edit", "update"]);
    $this->middleware("can:delete,manga")->only("delete");
  }

  /**
   * Retrieve a list of mangas and display them in the dashboard.mangas-list view.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $mangasQuery = auth()
      ->user()
      ->can("edit_all_mangas")
      ? Manga::query()
      : Manga::where("user_id", auth()->id());

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $mangasQuery->where("title", "LIKE", "%$title%");
    }

    $mangas = $mangasQuery
      ->latest()
      ->fastPaginate(20)
      ->through(function ($manga) {
        $manga->views = $manga->totalViews();
        $manga->type_title = $manga->types()->first()->title ?? null;
        $manga->status_title = $manga->statuses()->first()->title ?? null;
        return $manga;
      });

    return view("dashboard.mangas.index", compact("mangas"));
  }

  /**
   * Display the view for posting a manga.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.mangas.create");
  }

  /**
   * Store a new manga based on the provided request data.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $manga = $request->validate([
      "title" => "required",
      "slug" => ["required", Rule::unique("mangas", "slug"), 'regex:/^(?!random$)/i'],
      "description" => "nullable",
      "author" => "nullable",
      "artist" => "nullable",
      "genres" => "nullable",
      "official_links" => "nullable",
      "track_links" => "nullable",
      "alternative_titles" => "nullable",
      "releaseDate" => "nullable|numeric",
      "rate" => "nullable|numeric",
      "status" => "required",
      "type" => "required",
      "cover" => "required|image",
      "slider_option" => "required|in:1,0",
      "slider_cover" => "nullable|image",
      "post_status" => "required|in:publish,private",
    ]);

    try {
      $manga["cover"] = MangaHelper::uploadAndProcessCover($request->file("cover"));
      $manga["user_id"] = auth()->id();
      $manga["status"] = $manga["post_status"];
      $manga = Manga::create($manga);
      MangaHelper::attachGenres($request->input("genres"), $manga->id);
      MangaHelper::attachTaxonomy("status", $request->input("status"), $manga->id);
      MangaHelper::attachTaxonomy("type", $request->input("type"), $manga->id);
      if ($request->slider_option) {
        SliderHelper::uploadAndAttachSlider(Manga::class, $manga->id, $request);
        Cache::forget("slider_mangas");
      }

      Cache::forget("latest_mangas");
    } catch (Exception $e) {
      Log::error($e->getMessage());
      return back()->with("error", $e->getMessage());
    }

    Cache::forget("latest_mangas");
    return redirect(route("dashboard.mangas.index"))->with("success", __("Manga has been uploaded!"));
  }

  /**
   * Display the view for editing a manga.
   *
   * @param  \App\Models\Manga  $manga
   * @return \Illuminate\View\View
   */
  public function edit(Manga $manga)
  {
    return view("dashboard.mangas.edit", ["manga" => $manga]);
  }

  /**
   * Update the provided manga with the given request data.
   *
   * @param  \App\Models\Manga  $manga
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Manga $manga, Request $request)
  {
    $inputFields = $request->validate([
      "title" => "required",
      "slug" => ["required", Rule::unique("mangas", "slug")->ignore($manga->id)],
      "description" => "nullable",
      "author" => "nullable",
      "artist" => "nullable",
      "genres" => "nullable",
      "official_links" => "nullable",
      "track_links" => "nullable",
      "alternative_titles" => "nullable",
      "releaseDate" => "nullable|numeric",
      "rate" => "nullable|numeric",
      "status" => "nullable",
      "type" => "nullable",
      "cover" => "nullable|image",
      "slider_option" => "required|in:1,0",
      "slider_cover" => "nullable|image",
      "post_status" => "required|in:publish,private",
    ]);

    try {
      $inputFields["cover"] = MangaHelper::uploadAndProcessCover($request->file("cover"), $manga->id, $manga->cover);
      MangaHelper::attachGenres($request->input("genres"), $manga->id);
      MangaHelper::attachTaxonomy("status", $request->input("status"), $manga->id);
      MangaHelper::attachTaxonomy("type", $request->input("type"), $manga->id);
      SliderHelper::uploadAndAttachSlider(Manga::class, $manga->id, $request);
      if ($manga->slug != $inputFields["slug"]) {
        MangaHelper::renameContentFolder($manga->slug, $inputFields["slug"]);
      }
      $inputFields["status"] = $inputFields["post_status"];
      $manga->update($inputFields);
      Cache::flush();
    } catch (Exception $e) {
      Log::error($e->getMessage());
      return back()->with("error", $e->getMessage());
    }

    Cache::forget("manga_query_" . $manga->id);
    return back()->with("success", __("Manga has been updated!"));
  }

  /**
   * Delete a manga and its related data.
   *
   * @param  \App\Models\Manga  $manga
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Manga $manga)
  {
    $manga->chapters()->delete();
    $manga->comments()->delete();
    $manga->views()->delete();
    $manga->delete();
    Cache::flush();
    return back()->with("success", __("Manga has been deleted."));
  }

  /**
   * Retrieve a list of deleted mangas.
   *
   * @return \Illuminate\View\View
   */
  public function deleted(Request $request)
  {
    $mangasQuery = Manga::onlyTrashed();

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $mangasQuery->where("values->title", "LIKE", "%$title%");
    }

    $mangas = $mangasQuery->latest()->fastPaginate(20);

    // return $mangas;
    return view("dashboard.mangas.deleted", compact("mangas"));
  }

  /**
   * Restore a deleted manga.
   *
   * @param  int  $id  The ID of the manga to restore.
   * @return \Illuminate\Http\RedirectResponse
   */
  public function restore($id)
  {
    $manga = Manga::withTrashed()->findOrFail($id);
    $manga->restore();

    CacheHelper::forgetCache();
    return back()->with("success", __("Manga has been restored."));
  }

  /**
   * Permanently delete a manga and its associated deleted model.
   *
   * @param  int|string  $id  The ID or key of the manga to be permanently deleted.
   * @return \Illuminate\Http\RedirectResponse
   */
  public function hard_delete($id)
  {
    $manga = Manga::withTrashed()->findOrFail($id);
    $chapters = $manga
      ->chapters()
      ->withTrashed()
      ->get();
    $slider = Slider::where("manga_id", $manga->id)->first();

    if ($slider) {
      Storage::delete("/public/slider/" . $slider->image);
      $slider->delete();
    }

    foreach ($chapters as $chapter) {
      ChapterHelper::deleteChapterImages($chapter, $manga->slug);
    }

    $manga->chapters()->forceDelete();
    $manga->genres()->detach();

    Storage::delete("/public/covers/" . $manga->cover);

    $manga->forceDelete();

    CacheHelper::forgetCache();
    return back()->with("success", __("Manga has been permanently deleted."));
  }
}
