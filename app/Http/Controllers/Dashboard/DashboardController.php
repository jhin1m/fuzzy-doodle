<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\View;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Taxonomy;

class DashboardController
{
  /**
   * Display the dashboard index page.
   *
   * @return \Illuminate\View\View
   * @throws \Illuminate\Auth\Access\AuthorizationException
   */
  public function index()
  {
    $statistics = [
      "mangas" => Manga::count(),
      "chapters" => Chapter::count(),
      "users" => User::count(),
      "genres" => Taxonomy::where("type", "genre")->count(),
      "mangasViews" => Manga::getTotalViews(),
      "mangasPercentage" => $this->getPercentage(Manga::class),
      "chaptersViews" => Chapter::getTotalViews(),
      "chaptersPercentage" => $this->getPercentage(Chapter::class),
      "membersPercentage" => $this->getPercentage(User::class),
      "viewsPercentage" => $this->getPercentage(View::class),
    ];

    return view("dashboard.index", $statistics);
  }

  private function getPercentage($model)
  {
    $currentWeekRange = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
    $previousWeekRange = [
      Carbon::now()
        ->startOfWeek()
        ->subWeek(),
      Carbon::now()
        ->endOfWeek()
        ->subWeek(),
    ];

    $currentWeekViews = $model
      ::whereBetween("created_at", $currentWeekRange)
      ->when($model == View::class, fn($query) => $query->sum("views"), fn($query) => $query->count());

    $previousWeekViews = $model
      ::whereBetween("created_at", $previousWeekRange)
      ->when($model == View::class, fn($query) => $query->sum("views"), fn($query) => $query->count());

    $difference = $currentWeekViews - $previousWeekViews;
    $percentage = $previousWeekViews !== 0 ? ($difference / abs($previousWeekViews)) * 100 : 0;

    $formattedPercentage = ($percentage > 0 ? "+" : "") . number_format($percentage, 2) . "% " . __("from last week");

    return $formattedPercentage;
  }
}
