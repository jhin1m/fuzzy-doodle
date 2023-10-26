<?php

use App\Http\Controllers\Dashboard\Manga\MangaController;

Route::prefix('mangas')->group(
    function () {
        Route::get('/', [MangaController::class, 'index'])->middleware(['permission:view_mangas'])->name('dashboard.mangas.index');
        Route::get('/create', [MangaController::class, 'create'])->middleware(['permission:create_mangas'])->name('dashboard.mangas.create');
        Route::post('/store', [MangaController::class, 'store'])->middleware(['permission:create_mangas'])->name('dashboard.mangas.store');
        Route::get('/edit/{manga}', [MangaController::class, 'edit'])->middleware(['permission:edit_own_mangas|edit_all_mangas'])->name('dashboard.mangas.edit');
        Route::put('/update/{manga}', [MangaController::class, 'update'])->middleware(['permission:edit_own_mangas|edit_all_mangas'])->name('dashboard.mangas.update');
        Route::get('/delete/{manga}', [MangaController::class, 'delete'])->middleware(['permission:delete_own_mangas|delete_all_mangas'])->name('dashboard.mangas.delete');
        Route::get('/trash', [MangaController::class, 'deleted'])->middleware(['permission:restore_deleted_mangas'])->name('dashboard.mangas.deleted');
        Route::get('/trash/restore/{id}', [MangaController::class, 'restore'])->middleware(['permission:restore_deleted_mangas'])->name('dashboard.mangas.restore');
        Route::get('/trash/delete/{id}', [MangaController::class, 'hard_delete'])->middleware(['permission:restore_deleted_mangas'])->name('dashboard.mangas.hard_delete');

        require __DIR__ . '/mangas/status.php';
        require __DIR__ . '/mangas/types.php';
        require __DIR__ . '/mangas/chapters.php';
    }
);
