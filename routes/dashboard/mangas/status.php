<?php

use App\Http\Controllers\Dashboard\Manga\StatusController;

Route::prefix('status')->group(
    function () {
        Route::get('/', [StatusController::class, 'index'])->middleware(['permission:view_taxonomies'])->name('dashboard.mangas_status.index');
        Route::get('/create', [StatusController::class, 'create'])->middleware(['permission:create_taxonomies'])->name('dashboard.mangas_status.create');
        Route::post('/store', [StatusController::class, 'store'])->middleware(['permission:create_taxonomies'])->name('dashboard.mangas_status.store');
        Route::get('/edit/{id}', [StatusController::class, 'edit'])->middleware(['permission:edit_taxonomies'])->name('dashboard.mangas_status.edit');
        Route::put('/update/{id}', [StatusController::class, 'update'])->middleware(['permission:edit_taxonomies'])->name('dashboard.mangas_status.update');
        Route::get('/delete/{id}', [StatusController::class, 'delete'])->middleware(['permission:delete_taxonomies'])->name('dashboard.mangas_status.delete');
    }
);
