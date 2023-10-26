<?php

namespace App\Models;

use App\Models\Taxable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Taxonomy extends Model
{
  use HasFactory;

  protected $table = "taxonomies";
  protected $hidden = ["pivot"];

  protected $fillable = ["title", "slug", "type", "description", "parent_id"];

  protected static function boot()
  {
    parent::boot();

    static::deleting(function ($taxonomy) {
      $taxableType = $taxonomy->getMorphClass();

      $taxables = Taxable::where("taxonomy_id", $taxonomy->id)
        ->where("taxable_type", $taxableType)
        ->get();

      foreach ($taxables as $taxable) {
        $taxable->taxable->taxonomies()->detach($taxonomy);
      }
    });
  }

  public function taxables()
  {
    return $this->morphedByMany(Taxable::class, "taxable");
  }

  public function parent()
  {
    return $this->belongsTo(Taxonomy::class, "parent_id");
  }

  public function children()
  {
    return $this->hasMany(Taxonomy::class, "parent_id");
  }
}
