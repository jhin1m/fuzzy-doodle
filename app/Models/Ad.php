<?php

namespace App\Models;

use App\Models\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'identifier',
        'description',
        'image',
        'link',
        'script',
        'type',
        'is_active',
    ];

    public function views()
    {
        return $this->hasMany(View::class, 'key')->where('model', self::class);
    }

    public static function getTotalViews()
    {
        return self::with('views')->get()->sum(function ($chapter) {
            return $chapter->views->sum('views');
        });
    }
}
