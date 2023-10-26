<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookmarkController extends Controller
{
  /**
   * View the user's manga bookmarks.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $user = auth()->user();
    $perPage = 24;
    $currentPage = request()->query("page", 1);

    $mangaBookmarks = DB::table("bookmarks")
      ->where("bookmarks.user_id", $user->id)
      ->where("bookmarkable_type", Manga::class)
      ->join("mangas", "bookmarks.bookmarkable_id", "=", "mangas.id")
      ->select("bookmarks.id as id", "mangas.slug", "mangas.cover", "mangas.title", "bookmarks.created_at")
      ->orderBy("bookmarks.created_at")
      ->get();

    $mangaBookmarks->map(function ($bookmark) {
      $bookmark->type = "manga";
      return $bookmark;
    });

    $bookmarks = new Collection($mangaBookmarks);
    $bookmarks = $bookmarks->sortBy("id")->values();

    $total = $bookmarks->count();
    $start = ($currentPage - 1) * $perPage;
    $items = $bookmarks->slice($start, $perPage)->values();

    $paginatedBookmarks = new LengthAwarePaginator($items, $total, $perPage, $currentPage, ["path" => route("bookmarks.index")]);

    return view("pages.bookmarks", compact("paginatedBookmarks"));
  }

  /**
   * Add a manga from bookmarks.
   *
   * @param  \App\Models\Manga  $manga
   * @return \Illuminate\Http\RedirectResponse
   */
  public function toggle(Request $request, $type, $slug)
  {
    // Check if the provided type is valid (you can also use a validation rule here)
    if ($type != "manga") {
      return response()->json(["message" => "Invalid type"], 400);
    }

    // Determine the model class based on the type
    $modelClass = Manga::class;

    $user = auth()->user();
    $resource = $modelClass::where("slug", $slug)->first();

    if (!$resource) {
      return response()->json(["message" => "Resource not found."], 404);
    }

    $bookmark = $user
      ->bookmarks()
      ->where("bookmarkable_type", $modelClass)
      ->where("bookmarkable_id", $resource->id)
      ->first();

    if ($bookmark) {
      $bookmark->delete();
      return response()->json([
        "message" => __("Resource removed from bookmarks."),
        "btnText" => __("Add to Favorites"),
      ]);
    }

    $bookmark = new Bookmark([
      "bookmarkable_type" => $modelClass,
      "bookmarkable_id" => $resource->id,
    ]);

    $user->bookmarks()->save($bookmark);
    return response()->json([
      "message" => "Resource added to bookmarks.",
      "btnText" => __("Remove from Favorites"),
    ]);
  }
}
