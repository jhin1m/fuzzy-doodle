<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(["middleware" => ["checkInstallation"]], function () {
  require __DIR__ . "/public.php";
  require __DIR__ . "/manga.php";
  require __DIR__ . "/comments.php";
  require __DIR__ . "/user.php";
  require __DIR__ . "/bookmarks.php";
  require __DIR__ . "/fortify.php";
  require __DIR__ . "/dashboard.php";
});
