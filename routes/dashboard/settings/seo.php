<?php

use App\Http\Controllers\Dashboard\Setting\SeoController;

Route::prefix('seo')->group(
    function () {
        Route::get('/', [SeoController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.settings.index_seo');
        Route::put('/update', [SeoController::class, 'update'])->middleware(['permission:edit_settings'])->name('dashboard.settings.update_seo');
    }
);
