<?php

use App\Http\Controllers\Dashboard\DashboardController;

Route::middleware(["auth:sanctum", "verified", "permission:view_dashboard"])
  ->prefix("dashboard")
  ->group(function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard.index");

    require __DIR__ . "/dashboard/mangas.php";
    require __DIR__ . "/dashboard/genres.php";
    require __DIR__ . "/dashboard/pages.php";
    require __DIR__ . "/dashboard/comments.php";
    require __DIR__ . "/dashboard/users.php";
    require __DIR__ . "/dashboard/roles.php";
    require __DIR__ . "/dashboard/ads.php";
    require __DIR__ . "/dashboard/plugins.php";
    require __DIR__ . "/dashboard/settings.php";
  });
