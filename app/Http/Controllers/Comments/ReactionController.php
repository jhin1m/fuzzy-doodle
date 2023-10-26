<?php

namespace App\Http\Controllers\Comments;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\CommentReaction;
use Illuminate\Support\Facades\Cache;

class ReactionController
{
  /**
   * Toggle like/dislike for a comment.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\JsonResponse
   */
  public function toggleReaction(Request $request, Comment $comment)
  {
    $user_id = auth()->id();
    $type = $request->input("type");

    // Todo: add a check for type to make sure it's 1 or 2

    $reaction = CommentReaction::where("user_id", $user_id)
      ->where("comment_id", $comment->id)
      ->first();

    if ($reaction) {
      $reaction->delete();
      return response()->json(["message" => "success", "type" => $reaction->type == 1 ? "removing" : "adding", "toggle" => true]);
    } else {
      // If no reaction exists, create a new one
      $reaction = new CommentReaction();
      $reaction->user_id = $user_id;
      $reaction->comment_id = $comment->id;
      $reaction->type = $type;
      $reaction->save();
    }

    $content = $comment->commentable_type::findOrFail($comment->commentable_id);
    Cache::forget("comments_" . $content->slug . $content->id);

    return response()->json([
      "message" => "success",
      "type" => $type == 1 ? "adding" : "removing",
    ]);
  }
}
