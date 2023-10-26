<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
  use HasFactory;

  protected $fillable = ["name", "active", "activated_at"];
  protected $dates = ["activated_at"];

  public function activate()
  {
    $this->update([
      "active" => true,
    ]);
  }

  public function deactivate()
  {
    $this->update([
      "active" => false,
      // 'activated_at' => null,
    ]);
  }

  public function isActive()
  {
    return $this->active;
  }
}
