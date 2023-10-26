<?php

use App\Http\Controllers\Dashboard\Manga\TypeController;

Route::prefix('types')->group(
    function () {
        Route::get('/', [TypeController::class, 'index'])->middleware(['permission:view_taxonomies'])->name('dashboard.mangas_types.index');
        Route::get('/create', [TypeController::class, 'create'])->middleware(['permission:create_taxonomies'])->name('dashboard.mangas_types.create');
        Route::post('/store', [TypeController::class, 'store'])->middleware(['permission:create_taxonomies'])->name('dashboard.mangas_types.store');
        Route::get('/edit/{id}', [TypeController::class, 'edit'])->middleware(['permission:edit_taxonomies'])->name('dashboard.mangas_types.edit');
        Route::put('/update/{id}', [TypeController::class, 'update'])->middleware(['permission:edit_taxonomies'])->name('dashboard.mangas_types.update');
        Route::get('/delete/{id}', [TypeController::class, 'delete'])->middleware(['permission:delete_taxonomies'])->name('dashboard.mangas_types.delete');
    }
);
