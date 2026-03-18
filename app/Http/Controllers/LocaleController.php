<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function change($locale, Request $request)
    {
        $supportedLocales = array_keys(config('languages'));

        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'ar');
        }

        $isDashboard = $request->segment(1) === 'dashboard';

        if (Auth::check()) {
            $user = Auth::user();
            $isDashboard ? $user->dashboard_locale = $locale : $user->website_locale = $locale;
            /** @var \App\Models\User $user */
            $user->save();
        }

        $isDashboard ? session(['dashboard_locale' => $locale]) : session(['website_locale' => $locale]);

        return redirect()->back()->withSuccess(__('messages.language_changed'));
    }
}
