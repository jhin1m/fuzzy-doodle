<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\View;

class PageController extends Controller
{
    /**
     * View a page.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\View\View
     */
    public function show(Page $page)
    {
        View::create([
            'model' => Page::class,
            'key' => $page->id,
        ]);

        return view('pages.page', compact('page'));
    }
}
