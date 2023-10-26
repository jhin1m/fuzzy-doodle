<?php

use App\Http\Controllers\Dashboard\Ads\AdsController;

Route::prefix("ads")->group(function () {
  Route::get("/", [AdsController::class, "index"])->middleware(["permission:view_settings"])->name("dashboard.ads.index");
  Route::get("/create", [AdsController::class, "create"])->middleware(["permission:edit_settings"])->name("dashboard.ads.create");
  Route::post("/store", [AdsController::class, "store"])->middleware(["permission:edit_settings"])->name("dashboard.ads.store");
  Route::get("/edit/{ad}", [AdsController::class, "edit"])->middleware(["permission:edit_settings"])->name("dashboard.ads.edit");
  Route::put("/update/{ad}", [AdsController::class, "update"])->middleware(["permission:edit_settings"])->name("dashboard.ads.update");
  Route::get("/delete/{ad}", [AdsController::class, "delete"])->middleware(["permission:edit_settings"])->name("dashboard.ads.delete");
});
