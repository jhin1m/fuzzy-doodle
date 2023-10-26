<?php

use App\Http\Controllers\Dashboard\Genre\GenreController;

Route::prefix("genres")->group(function () {
  Route::get("/", [GenreController::class, "index"])->middleware(["permission:view_taxonomies"])->name("dashboard.genres.index");
  Route::get("/create", [GenreController::class, "create"])->middleware(["permission:create_taxonomies"])->name("dashboard.genres.create");
  Route::post("/store", [GenreController::class, "store"])->middleware(["permission:create_taxonomies"])->name("dashboard.genres.store");
  Route::get("/edit/{genre}", [GenreController::class, "edit"])->middleware(["permission:edit_taxonomies"])->name("dashboard.genres.edit");
  Route::put("/update/{genre}", [GenreController::class, "update"])->middleware(["permission:edit_taxonomies"])->name("dashboard.genres.update");
  Route::get("/delete/{genre}", [GenreController::class, "delete"])->middleware(["permission:delete_taxonomies"])->name("dashboard.genres.delete");
});
