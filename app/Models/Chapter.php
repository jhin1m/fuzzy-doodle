<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\View;
use App\Models\Manga;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Chapter
 *
 */
class Chapter extends Model
{
  use HasFactory;

  protected $fillable = ["chapter_number", "title", "manga_id", "user_id", "content"];

  protected $casts = [
    "content" => "array",
  ];

  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }

  public function manga()
  {
    return $this->belongsTo(Manga::class, "manga_id");
  }

  public function comments()
  {
    return $this->morphMany(Comment::class, "commentable");
  }

  public function views()
  {
    return $this->hasMany(View::class, "key")->where("model", self::class);
  }

  public function totalViews()
  {
    return View::where("model", self::class)
      ->where("key", $this->id)
      ->sum("views");
    // return $this->views->sum("views");
  }

  public function addView()
  {
    // Find an existing view for today with the same model and key
    $existingView = View::where([
      "model" => Chapter::class,
      "key" => $this->id,
    ])
      ->whereDate("created_at", "=", Carbon::now()->format("Y-m-d"))
      ->first();

    if ($existingView) {
      // If an existing view is found, increment its views column
      $existingView->increment("views");
      return $existingView;
    } else {
      // If no existing view is found, create a new view with views = 1 and today's date at 00:00
      $view = new View([
        "model" => Chapter::class,
        "key" => $this->id,
        "views" => 1,
        "created_at" => Carbon::today(),
      ]);

      $this->views()->save($view);

      return $view;
    }
  }

  public static function getTotalViews()
  {
    return View::where("model", self::class)->sum("views");
  }
}
