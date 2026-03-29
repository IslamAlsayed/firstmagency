<?php

namespace App\Http\Controllers;

use App\Models\LineWork;
use App\Models\Partner;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $data = [
            'lineWorks' => Cache::remember('home_line_works', config('app.cache_time'), function () {
                return LineWork::active()->published()->orderBy('order')->get();
            }),

            'partners' => Cache::remember('home_partners', config('app.cache_time'), function () {
                return Partner::active()->orderBy('order')->get();
            }),
        ];

        return view('website.about-us', compact('data'));
    }
}
