<?php

use App\Http\Controllers\Dashboard\Setting\ThemeController;

Route::prefix('theme')->group(
    function () {
        Route::get('/', [ThemeController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.settings.index_theme');
        Route::put('/update', [ThemeController::class, 'update'])->middleware(['permission:edit_settings'])->name('dashboard.settings.update_theme');
    }
);
