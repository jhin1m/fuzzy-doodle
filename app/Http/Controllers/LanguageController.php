<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, $locale)
    {
        if (in_array($locale, config('app.locales'))) {
            $request->session()->put('locale', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
