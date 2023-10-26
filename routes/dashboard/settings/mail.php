<?php

use App\Http\Controllers\Dashboard\Setting\MailController;

Route::prefix('mail')->group(
    function () {
        Route::get('/', [MailController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.settings.index_mail');
        Route::put('/update', [MailController::class, 'update'])->middleware(['permission:edit_settings'])->name('dashboard.settings.update_mail');
    }
);
