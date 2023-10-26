<?php

namespace App\Http\Controllers\Dashboard\Manga;

use Exception;
use ZipArchive;
use App\Models\View;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Comment;
use App\Helpers\CacheHelper;
use Illuminate\Http\Request;
use App\Helpers\ChapterHelper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class ChapterController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    $this->middleware("can:viewAny," . Chapter::class)->only("index");
    $this->middleware("can:create," . Chapter::class)->only(["create", "store"]);
    $this->middleware("can:update,chapter")->only(["edit", "update"]);
    $this->middleware("can:delete,chapter")->only("delete");
  }

  /**
   * Display the list of chapters.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $chaptersQuery = auth()
      ->user()
      ->can("edit_all_chapters")
      ? Chapter::query()
      : Chapter::where("user_id", auth()->id());

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $chaptersQuery->whereHas("manga", function ($chaptersQuery) use ($title) {
        $chaptersQuery->where("title", "LIKE", "%" . $title . "%");
      });
    }

    if ($request->filled("manga")) {
      $chaptersQuery->where("manga_id", $request->input("manga"));
    }

    $chapters = $chaptersQuery->latest()->fastPaginate(20);

    return view("dashboard.chapters.index", compact("chapters"));
  }

  /**
   * Display the form to create a new chapter.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    $this->authorize("create", Chapter::class);

    $mangas = Manga::orderBy("created_at", "desc")
      ->get()
      ->pluck("title", "id")
      ->toArray();

    return view("dashboard.chapters.create", compact("mangas"));
  }

  public function upload(Request $request)
  {
    return ChapterHelper::uploadChapter($request);
  }

  public function remove(Request $request)
  {
    // check if request->file is zip? do something, if not do something else
    return ChapterHelper::removeFile($request);
  }

  /**
   * Store a newly created chapter.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response|void
   */
  public function store(Request $request)
  {
    return ChapterHelper::storeChapter($request);
  }

  /**
   * Display the form to edit a chapter.
   *
   * @param  \App\Models\Chapter  $chapter
   * @return \Illuminate\View\View
   */
  public function edit(Chapter $chapter)
  {
    $this->authorize("update", $chapter);

    $mangas = Manga::orderBy("created_at", "desc")
      ->get()
      ->pluck("title", "id")
      ->toArray();
    return view("dashboard.chapters.edit", compact("mangas", "chapter"));
  }

  /**
   * Update the specified chapter.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Chapter  $chapter
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Chapter $chapter)
  {
    $formData = $request->validate([
      "title" => "nullable",
      "manga_id" => "required",
      "chapter_number" => "required",
    ]);

    $mangaIdChanged = $formData["manga_id"] != $chapter->manga->id;
    $chapterNumberChanged = $formData["chapter_number"] != $chapter->chapter_number;

    if ($mangaIdChanged || $chapterNumberChanged) {
      // Check if the new chapter number already exists for the new manga
      $existedChapter = Chapter::where("manga_id", $formData["manga_id"])
        ->where("chapter_number", $formData["chapter_number"])
        ->first();

      if ($existedChapter) {
        return back()->with("error", __("There is a chapter with this number already"));
      }

      // Rename the chapter folder if manga or chapter number has changed
      if ($mangaIdChanged) {
        $updatedManga = Manga::findOrFail($formData["manga_id"]);

        ChapterHelper::renameChapterFolder(
          $updatedManga->slug,
          $chapter->chapter_number,
          $formData["chapter_number"],
          $chapter->manga->slug
        );
      } elseif ($chapterNumberChanged) {
        ChapterHelper::renameChapterFolder($chapter->manga->slug, $chapter->chapter_number, $formData["chapter_number"]);
      }
    }

    // Update the chapter data
    $chapter->title = $formData["title"];
    $chapter->manga_id = $formData["manga_id"];
    $chapter->chapter_number = $formData["chapter_number"];
    $chapter->update();

    // Clear cache
    Cache::forget("manga_query_" . $chapter->manga->id);
    Cache::forget("chapter_query" . $chapter->manga->slug . $chapter->chapter_number);
    CacheHelper::clearCachedChaptersMangas();

    return back()->with("success", __("Chapter has been updated"));
  }

  public function updateContent(Chapter $chapter, Request $request)
  {
    return ChapterHelper::updateContent($chapter, $request);
  }

  /**
   * Delete the specified chapter.
   *
   * @param  \App\Models\Chapter  $chapter
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Chapter $chapter)
  {
    $this->authorize("delete", $chapter);

    // Delete the chapter's directory and its contents
    ChapterHelper::deleteChapterImages($chapter);
    Cache::forget("manga_query_" . $chapter->manga->id);
    Cache::forget("chapter_query" . $chapter->manga->slug . $chapter->chapter_number);
    CacheHelper::clearCachedChaptersMangas();

    View::where("model", Chapter::class)
      ->where("key", $chapter->id)
      ->delete();

    Comment::where("commentable_type", Chapter::class)
      ->where("commentable_id", $chapter->id)
      ->delete();
    $chapter->delete();

    return back()->with("success", __("Chapter has been deleted"));
  }
}
