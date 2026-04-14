<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FAQ;
use App\Models\ProgrammingCategory;
use App\Models\ProjectStep;
use Illuminate\Support\Facades\Cache;

class AppMobileController extends Controller
{
    public function index()
    {
        $data = [
            'programming_categories' => Cache::remember('app_mobile_programming_categories', config('app.cache_time'), function () {
                return ProgrammingCategory::active()->limit(3)->get();
            }),

            'project_steps' => Cache::remember('app_mobile_project_steps', config('app.cache_time'), function () {
                return ProjectStep::ordered()->get();
            }),

            'articles' => Article::active()->published()->forAppMobiles()->limit(4)->get(),

            'faqs' => Cache::remember('app_mobile_faqs', config('app.cache_time'), function () {
                return FAQ::active()->apps()->get();
            }),
        ];

        return view('website.appMobile', compact('data'));
    }
}
