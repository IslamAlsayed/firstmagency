<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\ProjectStep;
use Illuminate\Support\Facades\Cache;

class AppMobileController extends Controller
{
    public function index()
    {
        $data = [
            'categories' => Cache::remember('app_mobile_categories', 1800, function () {
                return Category::active()->get();
            }),

            'project_steps' => Cache::remember('app_mobile_project_steps', 1800, function () {
                return ProjectStep::ordered()->get();
            }),

            'articles' => Cache::remember('app_mobile_articles', 1800, function () {
                return Article::active()->forAppMobiles()->limit(4)->get();
            }),

            'faqs' => Cache::remember('app_mobile_faqs', 1800, function () {
                return FAQ::active()->apps()->get();
            }),
        ];

        return view('website.appMobile', compact('data'));
    }
}
