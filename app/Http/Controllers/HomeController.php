<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
  /**
   * Homepage view.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view("pages.home", [
      "popular" => $this->getCachedPopularMangas(),
      "sliders" => $this->getCachedSliderMangas(),
      "latest" => $this->getCachedLatestMangas(),
      "chapters" => $this->getCachedChaptersMangas(),
    ]);
  }

  /**
   * Get popular mangas with caching.
   *
   * @return \Illuminate\Cache\TCacheValue
   */
  private function getCachedPopularMangas()
  {
    $cacheKey = "popular_mangas";
    $cacheExpiration = Carbon::now()->addHours(3);

    return Cache::remember($cacheKey, $cacheExpiration, function () {
      $popularMangas = Manga::where("status", "publish")
        ->select(["id", "title", "description", "slug", "cover"])
        ->get()
        ->map(function ($manga) {
          $manga->description = strip_tags($manga->description);
          $manga->views = intval($manga->totalViews());

          return $manga;
        })
        ->sortByDesc("views")
        ->values()
        ->take(20);

      return $popularMangas;
    });
  }

  /**
   * Get slider mangas with caching.
   *
   * @return \Illuminate\Cache\TCacheValue
   */
  private function getCachedSliderMangas()
  {
    $cacheKey = "slider_mangas";
    $cacheExpiration = Carbon::now()->addHours(3);

    return Cache::remember($cacheKey, $cacheExpiration, function () {
      return Manga::whereHas("slider", function ($query) {
        $query->where("slidable_type", "=", Manga::class);
      })
        ->where("status", "publish")
        ->get()
        ->map(function ($manga) {
          $manga->type = "manga";
          $manga->views = $manga->totalViews();
          $manga->type_title = $manga->types()->first()->title ?? null;
          $manga->slider_image = $manga->slider()->first()->image ?? null;
          $manga->genres = $manga
            ->genres()
            ->select(["title", "slug"])
            ->get()
            ->take(5);
          return $manga;
        });
    });
  }

  /**
   * Get latest mangas with caching.
   *
   * @return \Illuminate\Cache\TCacheValue
   */
  private function getCachedLatestMangas()
  {
    $cacheKey = "latest_mangas";
    $cacheExpiration = Carbon::now()->addHours(3);

    return Cache::remember($cacheKey, $cacheExpiration, function () {
      return Manga::latest()
        ->where("status", "publish")
        ->select(["id", "title", "slug", "description", "cover", "rate"])
        ->fastPaginate(20);
    });
  }

  /**
   * Get chapters mangas with caching.
   *
   * @return \Illuminate\Cache\TCacheValue
   */
  private function getCachedChaptersMangas()
  {
    $perPage = 24;
    $currentPage = request()->get("page", 1);
    $cacheKey = "chapters_page_" . $currentPage;
    $cacheExpiration = Carbon::now()->addHours(3);

    return Cache::remember($cacheKey, $cacheExpiration, function () use ($perPage) {
      $query = Manga::whereHas("chapters")
        ->where("status", "publish")
        ->select(["id", "title", "slug", "description", "cover", "rate"])
        ->orderBy("updated_at", "desc");

      $mangas = $query->paginate($perPage);

      $mangas->getCollection()->transform(function ($manga) {
        $manga->chapters = Chapter::where("manga_id", $manga->id)
          ->select(["title", "chapter_number", "created_at"])
          ->orderByDesc("chapter_number")
          ->take(2)
          ->get();
        return $manga;
      });

      return $mangas;
    });
  }
}
