<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /**
     * Show the mail settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.settings.mail');
    }

    /**
     * Update the mail settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $setting = $request->validate([
            'driver' => 'required|in:smtp,sendmail,mailgun,ses,postmark,log,array',
            'host' => 'nullable',
            'port' => 'nullable|numeric',
            'username' => 'nullable',
            'password' => 'nullable',
            'encryption' => 'required|in:tls,ssl',
            "address" => "required|email",
        ]);

        settings()->set('mail.driver', $setting['driver']);
        settings()->set('mail.host', $setting['host']);
        settings()->set('mail.port', $setting['port']);
        settings()->set('mail.username', $setting['username']);
        settings()->set('mail.password', $setting['password']);
        settings()->set('mail.encryption', $setting['encryption']);
        settings()->set('mail.address', $setting['address']);

        return back()->with('success', __('Mail settings have been updated'));
    }
}
