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
            'lineWorks' => Cache::remember('home_line_works', 1800, function () {
                return LineWork::active()->published()->orderBy('order')->get();
            }),

            'partners' => Cache::remember('home_partners', 1800, function () {
                return Partner::active()->orderBy('order')->get();
            }),
        ];

        return view('website.about-us', compact('data'));
    }
}
