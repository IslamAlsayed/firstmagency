<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Service;
use App\Models\Review;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $data = [
            'settings' => Cache::remember('home_settings', 3600, function () {
                return Setting::first();
            }),

            'services' => Cache::remember('home_services', 1800, function () {
                return Service::active()->orderBy('order')->get();
            }),

            'projects' => Cache::remember('home_projects', 1800, function () {
                return Project::active()->orderBy('order')->get();
            }),

            'reviews' => Review::approved()->orderBy('created_at', 'desc')->get(),

            'clients' => Cache::remember('home_clients', 3600, function () {
                return Client::active()->orderBy('order')->get();
            }),
        ];

        return view('website.welcome', compact('data'));
    }
}
