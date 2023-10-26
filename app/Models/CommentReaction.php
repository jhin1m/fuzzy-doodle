<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CommentReaction
 *
 */
class CommentReaction extends Model
{
    protected $table = 'comments_reactions';

    use HasFactory;

    protected $fillable = ['user_id', 'comment_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id')->with('commentable');
    }
}
