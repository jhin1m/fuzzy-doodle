<?php

use App\Http\Controllers\Dashboard\Manga\ChapterController;
use App\Http\Controllers\Dashboard\Manga\BulkController;

Route::prefix('chapters')->group(
    function () {
        Route::get('/', [ChapterController::class, 'index'])->middleware(['permission:view_chapters'])->name('dashboard.chapters.index');
        Route::get('/create', [ChapterController::class, 'create'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.create');
        Route::post('/store', [ChapterController::class, 'store'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.store');
        Route::post('/upload', [ChapterController::class, 'upload'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.upload');
        Route::delete('/upload', [ChapterController::class, 'remove'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.upload');
        Route::get('/edit/{chapter}', [ChapterController::class, 'edit'])->middleware(['permission:edit_own_chapters|edit_all_chapters'])->name('dashboard.chapters.edit');
        Route::put('/update/{chapter}', [ChapterController::class, 'update'])->middleware(['permission:edit_own_chapters|edit_all_chapters'])->name('dashboard.chapters.update');
        Route::post('/update-content/{chapter}', [ChapterController::class, 'updateContent'])->middleware(['permission:edit_own_chapters|edit_all_chapters'])->name('dashboard.chapters.update-content');
        Route::get('/delete/{chapter}', [ChapterController::class, 'delete'])->middleware(['permission:delete_own_chapters|delete_all_chapters'])->name('dashboard.chapters.delete');
        Route::prefix('bulk')->group(
            function () {
                Route::get('/create', [BulkController::class, 'create'])->middleware(['permission:bulk_upload_chapters'])->name('dashboard.chapters.bulk.create');
                Route::post('/upload', [BulkController::class, 'upload'])->middleware(['permission:bulk_upload_chapters'])->name('dashboard.chapters.bulk.upload');
                Route::post('/store', [BulkController::class, 'store'])->middleware(['permission:bulk_upload_chapters'])->name('dashboard.chapters.bulk.store');
            }
        );
    }
);
