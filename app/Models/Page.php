<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Page
 *
 */
class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'key')->where('model', self::class);
    }

    public static function getTotalViews()
    {
        return self::with('views')->get()->sum(function ($manga) {
            return $manga->views->sum('views');
        });
    }
}
