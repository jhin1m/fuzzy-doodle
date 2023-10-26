<?php

use App\Http\Controllers\Dashboard\Role\RoleController;

Route::prefix("roles")->group(function () {
  Route::get("/", [RoleController::class, "index"])->middleware(["permission:view_roles"])->name("dashboard.roles.index");
  Route::get("/create", [RoleController::class, "create"])->middleware(["permission:create_roles"])->name("dashboard.roles.create");
  Route::post("/store", [RoleController::class, "store"])->middleware(["permission:create_roles"])->name("dashboard.roles.store");
  Route::get("/edit/{role}", [RoleController::class, "edit"])->middleware(["permission:edit_roles"])->name("dashboard.roles.edit");
  Route::put("/update/{role}", [RoleController::class, "update"])->middleware(["permission:edit_roles"])->name("dashboard.roles.update");
  Route::get("/delete/{role}", [RoleController::class, "delete"])->middleware(["permission:delete_roles"])->name("dashboard.roles.delete");
});
