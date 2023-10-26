<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
  /**
   * Show the user settings page.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view("pages.user");
  }
}
