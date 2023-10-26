<?php

namespace App\Models;

use App\Models\CommentReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Comment
 *
 */
class Comment extends Model
{
  use HasFactory;

  protected $fillable = ["user_id", "commentable_id", "commentable_type", "content"];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function commentable()
  {
    return $this->morphTo();
  }

  public function replies()
  {
    return $this->hasMany(Comment::class, "parent_id");
  }

  public function parent()
  {
    return $this->belongsTo(Comment::class, "parent_id");
  }

  public function reactions()
  {
    return $this->hasMany(CommentReaction::class);
  }

  public function likes()
  {
    return $this->hasMany(CommentReaction::class)->where("type", 1);
  }

  public function dislikes()
  {
    return $this->hasMany(CommentReaction::class)->where("type", 2);
  }

  public function likesSum()
  {
    if (!isset($this->likes_count)) {
      $this->loadCount(["likes", "dislikes"]);
    }

    return $this->likes_count - $this->dislikes_count;
  }
}
