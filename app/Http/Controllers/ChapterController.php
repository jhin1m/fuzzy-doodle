<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\View;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Support\Facades\Cache;

class ChapterController extends Controller
{
  /**
   * View a chapter of a manga.
   *
   * @param  \App\Models\Manga  $manga
   * @param  int  $chapterNumber
   * @return \Illuminate\View\View
   */
  public function show(Manga $manga, $chapterNumber)
  {
    $chapter = $manga
      ->chapters()
      ->where("chapter_number", $chapterNumber)
      ->firstOrFail();

    $chapter->addView();
    $cachedChapter = Cache::remember(
      "chapter_query" . $manga->slug . $chapter->chapter_number,
      Carbon::now()->addHours(3),
      function () use ($chapter) {
        $manga = $chapter
          ->manga()
          ->select(["id", "title", "slug", "alternative_titles"])
          ->first();

        $previousChapter = Chapter::where("manga_id", $manga->id)
          ->orderBy("chapter_number", "desc")
          ->where("chapter_number", "<", $chapter->chapter_number)
          ->select(["chapter_number"])
          ->first();

        $chapter->previous_chapter = $previousChapter->chapter_number ?? null;

        $nextChapter = Chapter::where("manga_id", $manga->id)
          ->orderBy("chapter_number", "asc")
          ->where("chapter_number", ">", $chapter->chapter_number)
          ->select(["chapter_number"])
          ->first();

        $chapter->next_chapter = $nextChapter->chapter_number ?? null;
        $chapter->content = $chapter->content ?? [];
        $chapter->manga = $manga;
        return $chapter;
      }
    );

    $chapter = $cachedChapter;
    // return $cachedChapter;

    $options = $manga
      ->chapters()
      ->orderByDesc("chapter_number")
      ->get(["chapter_number", "id"])
      ->pluck("chapter_number", "id");

    return view("pages.chapter", compact("chapter", "options"));
  }
}
