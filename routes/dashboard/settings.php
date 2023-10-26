<?php

use App\Http\Controllers\Dashboard\Setting\SettingController;

Route::prefix('settings')->group(
    function () {
        Route::get('/', [SettingController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.settings.index_site');
        Route::put('/update', [SettingController::class, 'update'])->middleware(['permission:edit_settings'])->name('dashboard.settings.update_site');
        Route::get('/cache/clear', [SettingController::class, 'clear_cache'])->middleware(['permission:edit_settings'])->name('dashboard.settings.clear_cache');

        require __DIR__ . '/settings/mail.php';
        require __DIR__ . '/settings/seo.php';
        require __DIR__ . '/settings/upload.php';
        require __DIR__ . '/settings/theme.php';
    }
);
