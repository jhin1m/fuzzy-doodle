<?php

use App\Http\Controllers\MangaController;
use App\Http\Controllers\ChapterController;

Route::group(["prefix" => "manga", "as" => "manga."], function () {
  Route::get("/", [MangaController::class, "index"])->name("index");
  Route::post("/search", [MangaController::class, "search"])->name("search");
  Route::get("/random", [MangaController::class, "random"])->name("random");
  Route::get("/{manga:slug}", [MangaController::class, "show"])->name("show");
  Route::get("/{manga:slug}/{chapter:chapter_number}", [ChapterController::class, "show"])->name("chapter.show");
});
