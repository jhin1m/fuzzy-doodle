<?php

use App\Http\Controllers\Dashboard\Setting\UploadController;

Route::prefix('upload')->group(
    function () {
        Route::get('/', [UploadController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.settings.index_upload');
        Route::put('/update', [UploadController::class, 'update'])->middleware(['permission:edit_settings'])->name('dashboard.settings.update_upload');
    }
);
