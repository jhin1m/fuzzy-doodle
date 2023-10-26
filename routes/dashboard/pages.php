<?php

use App\Http\Controllers\Dashboard\Page\PageController;

Route::prefix("pages")->group(function () {
  Route::get("/", [PageController::class, "index"])->middleware(["permission:view_pages"])->name("dashboard.pages.index");
  Route::get("/create", [PageController::class, "create"])->middleware(["permission:create_pages"])->name("dashboard.pages.create");
  Route::post("/store", [PageController::class, "store"])->middleware(["permission:create_pages"])->name("dashboard.pages.store");
  Route::get("/edit/{page}", [PageController::class, "edit"])->middleware(["permission:edit_pages"])->name("dashboard.pages.edit");
  Route::put("/update/{page}", [PageController::class, "update"])->middleware(["permission:edit_pages"])->name("dashboard.pages.update");
  Route::get("/delete/{page}", [PageController::class, "delete"])->middleware(["permission:delete_pages"])->name("dashboard.pages.delete");
  Route::get("/deleted", [PageController::class, "deleted"])->middleware(["permission:view_pages"])->name("dashboard.pages.deleted");
  Route::get("/{id}/restore", [PageController::class, "restore"])->middleware(["permission:restore_deleted_pages"])->name("dashboard.pages.restore");
  Route::get("/{page}/hard-delete", [PageController::class, "hard_delete"])->middleware(["permission:delete_pages"])->name("dashboard.pages.hard_delete");
});
