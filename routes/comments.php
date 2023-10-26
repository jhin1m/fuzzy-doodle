<?php

use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Comments\ReactionController;

Route::middleware(["auth:sanctum", "verified"])
  ->prefix("comments")
  ->group(function () {
    Route::post("/toggle/{comment}", [ReactionController::class, "toggleReaction"])->name("comments.reaction.toggle");
    Route::post("/like/{comment}", [ReactionController::class, "like_store"])->name("comments.like.store");
    Route::post("/dislike/{comment}", [ReactionController::class, "dislike_store"])->name("comments.dislike.store");

    Route::post("/post", [CommentController::class, "store"])->name("comments.store");
    Route::delete("/delete/{comment}", [CommentController::class, "delete"])->name("comments.delete");
  });
