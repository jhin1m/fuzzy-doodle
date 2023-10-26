<?php

use App\Http\Controllers\Dashboard\Plugin\PluginController;

Route::prefix("plugins")->group(function () {
  Route::get("/", [PluginController::class, "index"])->middleware('permission:view_plugins')->name("dashboard.plugins.index");
  Route::get("/activate/{plugin}", [PluginController::class, "activate"])->middleware('permission:edit_plugins')->name("dashboard.plugins.activate");
  Route::get("/deactivate/{plugin}", [PluginController::class, "deactivate"])->middleware('permission:edit_plugins')->name("dashboard.plugins.deactivate");
});
