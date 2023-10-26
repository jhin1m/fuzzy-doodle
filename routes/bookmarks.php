<?php

use App\Http\Controllers\BookmarkController;

Route::middleware(["auth:sanctum"])
  ->prefix("bookmarks")
  ->group(function () {
    Route::get("/", [BookmarkController::class, "index"])->name("bookmarks.index");
    Route::post("/toggle/{type}/{slug}", [BookmarkController::class, "toggle"])->name("bookmarks.store");
  });
