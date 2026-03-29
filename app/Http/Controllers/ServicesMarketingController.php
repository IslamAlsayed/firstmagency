<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FAQ;
use App\Models\MarketingPackage;
use App\Models\PlatformManagement;
use App\Models\WorkUsStep;
use Illuminate\Support\Facades\Cache;

class ServicesMarketingController extends Controller
{
    public function index()
    {
        $data = [
            'platforms' => Cache::remember('marketing_platforms', config('app.cache_time'), function () {
                return PlatformManagement::active()->ordered()->get();
            }),

            'work_steps' => Cache::remember('marketing_work_steps', config('app.cache_time'), function () {
                return WorkUsStep::active()->ordered()->get();
            }),

            'packages' => Cache::remember('marketing_packages', config('app.cache_time'), function () {
                return MarketingPackage::active()->ordered()->get();
            }),

            'articles' => Cache::remember('marketing_articles', config('app.cache_time'), function () {
                return Article::active()->forMarketing()->limit(4)->get();
            }),

            'faqs' => Cache::remember('marketing_faqs', config('app.cache_time'), function () {
                return FAQ::active()->servicesMarketing()->get();
            }),
        ];

        return view('website.servicesMarketing', compact('data'));
    }
}
