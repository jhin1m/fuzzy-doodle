<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/language/{locale}', [LanguageController::class, 'index'])->name('language.switch');
Route::get('/ads/{ad}', [AdsController::class, 'redirect'])->name('ads.redirect');
