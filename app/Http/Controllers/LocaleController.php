<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function change($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'ar';
        }
        session(['locale' => $locale]);
        app()->setLocale($locale);
        return redirect()->back();
    }
}
