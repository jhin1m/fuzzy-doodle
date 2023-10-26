<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\View;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function redirect(Ad $ad)
    {
        View::create([
            'model' => Ad::class,
            'key' => $ad->id,
        ]);

        return redirect($ad->link);
    }
}
