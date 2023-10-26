<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  use HasFactory;

  protected $table = "slider";

  protected $fillable = ["slidable_type", "slidable_id", "image"];

  public function slidable()
  {
    return $this->morphTo();
  }
}
