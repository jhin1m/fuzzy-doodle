<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\View;
use App\Models\Slider;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Manga
 *
 */
class Manga extends Model
{
  // use HasFactory, SoftDeletes;
  use HasFactory;

  protected $fillable = [
    "title",
    "slug",
    "description",
    "author",
    "artist",
    "official_links",
    "track_links",
    "alternative_titles",
    "cover",
    "views",
    "rate",
    "likes",
    "user_id",
    "releaseDate",
    "status",
  ];
  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }

  public function taxables()
  {
    return $this->morphMany(Taxable::class, "taxable");
  }

  public function chapters()
  {
    return $this->hasMany(Chapter::class, "manga_id");
  }

  public function genres()
  {
    return $this->morphToMany(Taxonomy::class, "taxable")->where("type", "genre");
  }

  public function statuses()
  {
    return $this->morphToMany(Taxonomy::class, "taxable")->where("type", "status");
  }

  public function types()
  {
    return $this->morphToMany(Taxonomy::class, "taxable")->where("type", "type");
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
  }

  public function addView()
  {
    // Find an existing view for today with the same model and key
    $existingView = View::where([
      "model" => Manga::class,
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
        "model" => Manga::class,
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

  public function bookmarks()
  {
    return $this->morphMany(Bookmark::class, "bookmarkable");
  }

  public function slider()
  {
    return $this->morphMany(Slider::class, "slidable");
  }
}
