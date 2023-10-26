<?php

use App\Http\Controllers\Dashboard\User\UserController;

Route::prefix("users")->group(function () {
  Route::get("/", [UserController::class, "index"])->middleware(["permission:view_users"])->name("dashboard.users.index");
  Route::get("/create", [UserController::class, "create"])->middleware(["permission:create_users"])->name("dashboard.users.create");
  Route::post("/store", [UserController::class, "store"])->middleware(["permission:create_users"])->name("dashboard.users.store");
  Route::get("/edit/{user}", [UserController::class, "edit"])->middleware(["permission:edit_users"])->name("dashboard.users.edit");
  Route::put("/update/{user}", [UserController::class, "update"])->middleware(["permission:edit_users"])->name("dashboard.users.update");
  Route::get("/delete/{user}", [UserController::class, "delete"])->middleware(["permission:delete_users"])->name("dashboard.users.delete");
  Route::get("/deleted", [UserController::class, "deleted"])->middleware(["permission:restore_deleted_users"])->name("dashboard.users.deleted");
  Route::get("/{id}/restore", [UserController::class, "restore"])->middleware(["permission:restore_deleted_users"])->name("dashboard.users.restore");
  Route::get("/{id}/hard-delete", [UserController::class, "hard_delete"])->middleware(["permission:delete_users"])->name("dashboard.users.hard_delete");
});
