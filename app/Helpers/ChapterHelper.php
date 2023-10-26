<?php

namespace App\Helpers;

use Exception;
use ZipArchive;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Support\Str;
use App\Helpers\CacheHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class ChapterHelper
{
  const TEMP_DIR = "temp_upload";
  const TARGET_DIR = "public/content";

  /**
   * Get the list of files in a ZIP archive.
   *
   * @param ZipArchive $zip
   * @return array
   */
  public static function getZipFileList(ZipArchive $zip)
  {
    $fileList = [];

    for ($i = 0; $i < $zip->numFiles; $i++) {
      $filename = $zip->getNameIndex($i);
      $fileList[] = $filename;
    }

    sort($fileList);

    return $fileList;
  }

  /**
   * Check if a filename represents an image file.
   *
   * @param string $filename
   * @return bool
   */
  public static function isImageFile($filename)
  {
    $imageExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array(strtolower($fileExtension), $imageExtensions);
  }

  /**
   * Generate a unique image name.
   *
   * @param string $mangaSlug
   * @param int $chapterNumber
   * @return string
   */
  public static function generateUniqueImageName($mangaSlug, $chapterNumber, $extension)
  {
    $randomName = uniqid();
    return "{$randomName}.{$extension}";
  }

  /**
   * Store an image.
   *
   * @param string $imageContent
   * @param string $imageName
   * @param string $mangaSlug
   * @param int $chapterNumber
   * @return string|\Illuminate\Http\RedirectResponse
   */
  public static function storeImage($imageContent, $mangaSlug, $chapterNumber, $extension)
  {
    try {
      $imageHeight = Image::make($imageContent)->height();

      if (settings()->get("image-encoding") && $imageHeight <= 16380) {
        $imgData = Image::make($imageContent)->encode($extension, settings()->get("quality"));
        $destinationPath = self::getChapterImagePath($mangaSlug, $chapterNumber, $extension);
        Storage::put($destinationPath, $imgData, "public");
        return basename($destinationPath);
      } else {
        $chapterPath = self::TARGET_DIR . "/{$mangaSlug}/{$chapterNumber}";

        if (!Storage::exists($chapterPath)) {
          Storage::makeDirectory($chapterPath);
        }

        $destinationPath = "{$chapterPath}";
        $imageName = basename(Storage::put($destinationPath, $imageContent, "public"));
        return $imageName;
      }
    } catch (Exception $e) {
      Log::error($e->getMessage());
      throw new Exception("Error processing image: " . $e->getMessage());
    }
  }

  /**
   * Get the storage path for a chapter image.
   *
   * @param string $mangaSlug
   * @param int $chapterNumber
   * @return string
   */
  public static function getChapterImagePath($mangaSlug, $chapterNumber, $extension)
  {
    $imageName = self::generateUniqueImageName($mangaSlug, $chapterNumber, $extension);
    return self::TARGET_DIR . "/{$mangaSlug}/{$chapterNumber}/{$imageName}";
  }

  /**
   * Delete the images of a chapter.
   *
   * @param Chapter $chapter
   * @return void
   */
  public static function deleteChapterImages(Chapter $chapter, $slug = null)
  {
    if ($slug) {
      // for deleted chapters
      $mangaSlug = $slug;
    } else {
      $mangaSlug = $chapter->manga->slug;
    }
    $chapterNumber = $chapter->chapter_number;
    $directoryPath = self::TARGET_DIR . "/{$mangaSlug}/{$chapterNumber}";
    Storage::deleteDirectory($directoryPath);
  }

  /**
   * Rename the folder of a chapter.
   *
   * @param string $mangaSlug
   * @param int $currentChapterNumber
   * @param int $newChapterNumber
   * @return void
   */
  public static function renameChapterFolder($mangaSlug, $currentChapterNumber, $newChapterNumber, $oldSlug = null)
  {
    if ($oldSlug) {
      $currentPath = self::TARGET_DIR . "/{$oldSlug}/{$currentChapterNumber}";
    } else {
      $currentPath = self::TARGET_DIR . "/{$mangaSlug}/{$currentChapterNumber}";
    }
    $newPath = self::TARGET_DIR . "/{$mangaSlug}/{$newChapterNumber}";

    if (Storage::exists($currentPath)) {
      Storage::move($currentPath, $newPath);
    }
  }

  /**
   * Extract images from a folder and store them.
   *
   * @param string $folderPath The path to the folder containing the images.
   * @param string $mangaSlug The slug of the manga.
   * @param int $chapterNumber The number of the chapter.
   * @return array The array of stored image names.
   */
  public static function extractImagesFromFolder($folderPath, $mangaSlug, $chapterNumber)
  {
    $images = [];

    $files = glob($folderPath . "/*.{jpg,jpeg,png,webp}", GLOB_BRACE);
    foreach ($files as $file) {
      $pathInfo = pathinfo($file);
      $imageHeight = Image::make($file)->height();

      if (settings()->get("image-encoding") && $imageHeight <= 16380) {
        $extension = self::getExtension($file);
        $imageContent = file_get_contents($file);
        $imageName = self::storeImage($imageContent, $mangaSlug, $chapterNumber, $extension);
      } else {
        $extension = $pathInfo["extension"];
        $randomName = uniqid() . "." . $extension;
        $destinationFolder = self::TARGET_DIR . "/{$mangaSlug}/{$chapterNumber}";
        Storage::put("{$destinationFolder}/{$randomName}", file_get_contents($file));
        $imageName = $randomName;
      }
      $images[] = $imageName;
    }

    return $images;
  }

  /**
   * Store a new chapter from a request.
   *
   * @param \Illuminate\Http\Request $request The incoming HTTP request.
   *
   * @return \Illuminate\Http\RedirectResponse|void
   */
  public static function storeChapter(Request $request)
  {
    try {
      $manga = Manga::findOrFail($request["manga_id"]);
      $chapterData = $manga
        ->chapters()
        ->where("chapter_number", $request->chapter_number)
        ->first();

      if ($chapterData) {
        // TODO: Remove the images that have been uploaded
        self::removeTempImages($request["files"]);

        flash()->addError(__("Chapter is already exists"));
        return response()->json(["error" => __("Chapter is already exists")]);
      }

      $validator = Validator::make($request->all(), [
        "manga_id" => "required|not_in:0",
        "title" => "nullable",
        "chapter_number" => "required|numeric",
        "files" => "required|array",
      ]);

      if ($validator->fails()) {
        $errors = [];
        foreach ($validator->errors()->all() as $error) {
          $errors[] = $error;
        }

        flash()->addError(implode("<br>", $errors));
        return response()->json(["error" => implode("<br>", $errors)]);
      }

      $chapter = $validator->validated();
      $chapter["content"] = $request["files"];
      $chapter["user_id"] = auth()->id();
      $chapter["title"] = $request->title;

      self::moveImagesToTargetDirectory($request["files"], $manga->slug, $request->chapter_number);
      self::removeTempImages($request["files"]);
      Chapter::create($chapter);

      $manga->touch();

      CacheHelper::clearCachedChaptersMangas();
      flash()->addSuccess(__("Chapter has been published"));
      return response()->json(["success" => __("Chapter has been published")]);
    } catch (Exception $e) {
      Log::error($e->getMessage());
      flash()->addError($e->getMessage());
      return response()->json(["error" => $e->getMessage()]);
    }
  }

  public static function uploadChapter(Request $request)
  {
    try {
      // $tempDir = storage_path("app/temp_upload_" . auth()->user()->username);
      File::ensureDirectoryExists(self::TEMP_DIR);

      if ($request->hasFile("file")) {
        // TODO: Check if image before processing

        $image = $request->file("file");
        $file_name = self::processImage($image);

        return response()->json(["success" => __("Image has been uploaded"), "filename" => $file_name]);
      } else {
        return response()->json(["error" => "Invalid file"]);
      }
    } catch (Exception $e) {
      Log::error($e->getMessage());
      return response()->json(["error" => "An error occurred"]);
    }
  }

  private static function processImage($image)
  {
    try {
      $extension = self::getExtension($image);
      $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
      $destinationPath = self::TEMP_DIR . "/" . uniqid() . "_" . Str::random(4) . "." . $extension;

      if (!settings()->get("image-encoding")) {
        $shouldEncode = false;
      } else {
        $imageHeight = Image::make($image)->height();
        $shouldEncode = $imageHeight <= 16380;
      }

      if ($shouldEncode) {
        $imgData = Image::make($image)->encode($extension, settings()->get("quality"));
        $file = Storage::put($destinationPath, $imgData, "public");

        return basename($destinationPath);
      } else {
        $file = Storage::putFileAs(self::TEMP_DIR, $image, uniqid() . "_" . Str::random(4) . "." . $image->getClientOriginalExtension());
        return basename($file);
      }
    } catch (Exception $e) {
      Log::error($e->getMessage());
      throw new Exception("Error processing image: " . $e->getMessage());
    }
  }

  private static function moveImagesToTargetDirectory($imageNames, $mangaSlug, $chapterNumber)
  {
    foreach ($imageNames as $imageName) {
      $sourcePath = self::TEMP_DIR . "/" . $imageName;
      $targetPath = self::TARGET_DIR . "/" . $mangaSlug . "/" . $chapterNumber . "/" . $imageName;

      Storage::move($sourcePath, $targetPath);
    }
  }

  private static function removeTempImages($imagesNames)
  {
    foreach ($imagesNames as $imageName) {
      Storage::delete(self::TEMP_DIR . "/" . $imageName);
    }
  }

  public static function removeFile(Request $request)
  {
    $image = $request->filename;

    if (Storage::has(self::TEMP_DIR . "/" . $image)) {
      Storage::delete(self::TEMP_DIR . "/" . $image);
      return response()->json(["success" => "File removed"]);
    } else {
      return response()->json(["error" => "File not found"]);
    }
  }

  public static function getExtension($file)
  {
    $extension = settings()->get("extension") == "same" ? $file->getClientOriginalExtension() : settings()->get("extension");
    return $extension;
  }

  public static function uploadBulkFile(Request $request)
  {
    try {
      File::ensureDirectoryExists(self::TEMP_DIR);
      $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
      if (!$receiver->isUploaded()) {
        throw new UploadMissingFileException();
      }
      $save = $receiver->receive();
      if ($save->isFinished()) {
        $zipPath = $save->getFile()->getPathname();
        $file_name = Storage::putFile(self::TEMP_DIR, $zipPath, "public");
        unlink($save->getFile()->getPathname());
        return response()->json(["success" => __("File has been uploaded"), "filename" => basename($file_name)]);
      } else {
        $handler = $save->handler();

        return response()->json([
          "done" => $handler->getPercentageDone(),
          "status" => true,
        ]);
      }
    } catch (Exception $e) {
      Log::error($e->getMessage());
      return response()->json(["error" => "An error occurred"]);
    }
  }

  public static function processBulk(Request $request)
  {
    try {
      // Log::info($request);
      $mangaId = $request["manga_id"];
      $manga = Manga::findOrFail($mangaId);

      // Extract the ZIP File to random folder name
      $file_path = storage_path("app/" . self::TEMP_DIR . "/" . basename($request["file"]));
      $extractedPath = storage_path("app/" . self::TEMP_DIR . "/" . Str::random(4));
      $zip = new ZipArchive();
      $zip->open($file_path);
      $zip->extractTo($extractedPath);
      $zip->close();

      // Get the list of files in the extracted path
      $extractedFiles = glob($extractedPath . "/*");

      // Check if all extracted files are directories
      $allAreFolders = true;
      foreach ($extractedFiles as $file) {
        if (!is_dir($file)) {
          $allAreFolders = false;
          break;
        }
      }

      if (!$allAreFolders) {
        // Clean up the extracted files
        Storage::deleteDirectory(self::TEMP_DIR . "/" . basename($extractedPath));
        Storage::delete(self::TEMP_DIR . "/" . basename($file_path));

        flash()->addError(__("Invalid chapter structure in the zip file. Only folders are allowed"));
        return response()->json(["error" => __("Invalid chapter structure in the zip file. Only folders are allowed")]);
      }

      // Get the list of folders in the extracted path
      $folders = glob($extractedPath . "/*", GLOB_ONLYDIR);

      // Process each folder as a chapter
      $failedFolders = [];
      foreach ($folders as $folder) {
        $chapterNumber = basename($folder);
        if ($chapterNumber === "random") {
          $failedFolders[] = $chapterNumber;
          continue;
        }

        $chapterData = $manga
          ->chapters()
          ->where("chapter_number", $chapterNumber)
          ->first();
        if ($chapterData) {
          $failedFolders[] = $chapterNumber;
          continue;
        }

        $extractedImages = ChapterHelper::extractImagesFromFolder($folder, $manga->slug, $chapterNumber);
        $chapterData = [
          "content" => $extractedImages,
          "manga_id" => $mangaId,
          "chapter_number" => $chapterNumber,
          "user_id" => auth()->id(),
        ];

        Chapter::create($chapterData);
      }

      Storage::deleteDirectory(self::TEMP_DIR . "/" . basename($extractedPath));
      Storage::delete(self::TEMP_DIR . "/" . basename($file_path));

      $manga->touch();

      if (!empty($failedFolders)) {
        flash()->addError(__("Failed to create chapters for the following folders: ") . implode(", ", $failedFolders));
        return response()->json(["error" => __("Failed to create chapters for the following folders: ") . implode(", ", $failedFolders)]);
      }

      flash()->addSuccess(__("Chapters have been published"));
      return response()->json(["success" => __("Chapters have been published: ")]);
    } catch (Exception $e) {
      Log::error($e->getMessage() . " At line " . $e->getLine());
      flash()->addError($e->getMessage());
      return response()->json(["error" => $e->getMessage()]);
    }
  }

  /**
   * Store a new chapter from a request.
   *
   * @param \Illuminate\Http\Request $request The incoming HTTP request.
   *
   * @return \Illuminate\Http\RedirectResponse|void
   */
  public static function updateContent(Chapter $chapter, Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        "files" => "required|array",
      ]);

      if ($validator->fails()) {
        $errors = [];
        foreach ($validator->errors()->all() as $error) {
          $errors[] = $error;
        }

        flash()->addError(implode("<br>", $errors));
        return response()->json(["error" => implode("<br>", $errors)]);
      }

      $validator->validated();

      $chapterPath = self::TARGET_DIR . "/{$chapter->manga->slug}/{$chapter->chapter_number}";

      if (Storage::exists($chapterPath)) {
        Storage::deleteDirectory($chapterPath);
      }

      self::moveImagesToTargetDirectory($request["files"], $chapter->manga->slug, $chapter->chapter_number);
      self::removeTempImages($request["files"]);

      $chapter->content = $request["files"];
      $chapter->update();
      $chapter->touch();
      $chapter->manga->touch();

      Cache::forget("manga_query_" . $chapter->manga->id);
      Cache::forget("chapter_query" . $chapter->manga->slug . $chapter->chapter_number);
      CacheHelper::clearCachedChaptersMangas();
      flash()->addSuccess(__("Chapter has been updated"));
      return response()->json(["success" => __("Chapter has been published")]);
    } catch (Exception $e) {
      Log::error($e->getMessage());
      flash()->addError($e->getMessage());
      return response()->json(["error" => $e->getMessage()]);
    }
  }
}
