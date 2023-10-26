<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      "comment" => "required|min:10|max:500",
    ]);

    $commentableType = $request->type;
    if (!class_exists($commentableType)) {
      return back()->with("error", __("Invalid commentable type."));
    }

    // Create a new comment
    $comment = new Comment();
    $comment->user_id = auth()->id();
    $comment->content = $request->input("comment");
    $comment->commentable_type = $commentableType;
    $comment->commentable_id = $request->key;

    // Security Check: Check if the commentable item exists
    $content = $request->type::findOrFail($request->key);

    $comment->save();

    Cache::forget("comments_" . $content->slug . $content->id);

    // Redirect back or perform any other actions
    return back()->with("success", __("Comment has been commented"));
  }

  public function delete(Comment $comment)
  {
    if (
      $comment->user_id == auth()->id() ||
      auth()
        ->user()
        ->can("delete_comments")
    ) {
      $comment->delete();
      return back()->with("success", __("Comment deleted successfully"));
    } else {
      abort(403);
    }
  }
}
