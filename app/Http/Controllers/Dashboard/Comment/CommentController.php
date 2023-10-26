<?php

namespace App\Http\Controllers\Dashboard\Comment;

use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the list of comments.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $commentsQuery = Comment::query();

    if ($request->filled("filter")) {
      $content = $request->input("filter");

      $commentsQuery->where("content", "LIKE", "%" . $content . "%");
    }

    // Add a condition for valid commentable types
    $validCommentableTypes = [Manga::class, Chapter::class, Comment::class];
    $commentsQuery->whereIn("commentable_type", $validCommentableTypes);

    $comments = $commentsQuery->latest()->fastPaginate(20);

    return view("dashboard.comments.index", compact("comments"));
  }

  /**
   * Edit a comment.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\View\View
   */
  public function edit(Comment $comment)
  {
    return view("dashboard.comments.edit", compact("comment"));
  }

  /**
   * Update the specified comment.
   *
   * @param  \App\Models\Comment  $comment
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Comment $comment, Request $request)
  {
    $request->validate([
      "content" => ["required"],
    ]);

    $comment->update(["content" => $request->input("content")]);

    $content = $comment->commentable_type::findOrFail($comment->commentable_id);
    Cache::forget("comments_" . $content->slug . $content->id);

    return back()->with("success", __("Comment has been updated"));
  }

  /**
   * Delete the specified comment.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Comment $comment)
  {
    $content = $comment->commentable_type::findOrFail($comment->commentable_id);
    Cache::forget("comments_" . $content->slug . $content->id);

    $comment->delete();

    return back()->with("success", __("Comment has been deleted"));
  }
}
