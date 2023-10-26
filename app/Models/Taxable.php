<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\TaxableScope;

class Taxable extends Model
{
  use HasFactory;

  protected $fillable = ["taxonomy_id", "taxable_id", "taxable_type"];

  protected static function boot()
  {
    parent::boot();
  }

  public function taxonomy()
  {
    return $this->morphToMany(Taxonomy::class, "taxable");
  }
}
