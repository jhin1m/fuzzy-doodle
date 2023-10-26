<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Bookmark;
use App\Models\CommentReaction;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 */
class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ["username", "email", "password", "role", "activation_code", "description"];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ["password", "remember_token"];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    "email_verified_at" => "datetime",
    "password" => "hashed",
  ];

  public function bookmarks()
  {
    return $this->hasMany(Bookmark::class, "user_id");
  }

  public function reactions()
  {
    return $this->hasMany(CommentReaction::class, "user_id");
  }
}
