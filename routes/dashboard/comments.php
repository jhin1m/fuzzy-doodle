<?php

use App\Http\Controllers\Dashboard\Comment\CommentController;

Route::prefix("comments")->group(function () {
  Route::get("/", [CommentController::class, "index"])->middleware(["permission:view_comments"])->name("dashboard.comments.index");
  Route::get("/edit/{comment}", [CommentController::class, "edit"])->middleware(["permission:edit_comments"])->name("dashboard.comments.edit");
  Route::put("/update/{comment}", [CommentController::class, "update"])->middleware(["permission:edit_comments"])->name("dashboard.comments.update");
  Route::get("/delete/{comment}", [CommentController::class, "delete"])->middleware(["permission:delete_comments"])->name("dashboard.comments.delete");
});
