<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\FAQ;
use App\Models\ProgrammingSystem;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

class WebsiteController extends Controller
{
    public function index()
    {
        $data = [
            'programming_systems' => Cache::remember('home_programming_systems', config('app.cache_time'), function () {
                return ProgrammingSystem::active()->orderBy('order')->get();
            }),

            'articles' => Cache::remember('home_articles', config('app.cache_time'), function () {
                return Article::active()->forWebsites()->limit(4)->get();
            }),

            'website_design' => Cache::remember('website_design_stats', config('app.cache_time'), function () {
                return [
                    'clients_count' => Client::count(),
                    'projects_count' => Project::count(),
                    'tickets_count' => Ticket::count(),
                ];
            }),

            'faqs' => Cache::remember('home_faqs', config('app.cache_time'), function () {
                return FAQ::active()->websites()->get();
            }),
        ];

        return view('website.websiteDeveloper', compact('data'));
    }
}
