<?php

namespace App\Http\Controllers;

use App\Models\DashboardsAndSystem;
use App\Models\FAQ;
use App\Models\HostingFeature;
use App\Models\HostingPackage;
use Illuminate\Support\Facades\Cache;

class HostingController extends Controller
{
    public function index()
    {
        $data = [
            'hosting_features' => Cache::remember('hosting_features', config('app.cache_time'), function () {
                return HostingFeature::ordered()->get();
            }),

            'packages' => [
                'hosting' => Cache::remember('hosting_packages', config('app.cache_time'), function () {
                    return HostingPackage::hostingPackages()->get();
                }),

                'reseller' => Cache::remember('hosting_reseller_packages', config('app.cache_time'), function () {
                    return HostingPackage::resellerPackages()->get();
                }),

                'vps' => Cache::remember('hosting_vps_packages', config('app.cache_time'), function () {
                    return HostingPackage::vpsPackages()->get();
                }),

                'server' => Cache::remember('hosting_server_packages', config('app.cache_time'), function () {
                    return HostingPackage::serverPackages()->get();
                }),
            ],

            'operating' => [
                'systems' => Cache::remember('operating_systems', config('app.cache_time'), function () {
                    return DashboardsAndSystem::operatingSystems()->get();
                }),

                'apps' => Cache::remember('dashboards_apps', config('app.cache_time'), function () {
                    return DashboardsAndSystem::dashboardsApps()->get();
                }),
            ],

            'faqs' => Cache::remember('hosting_faqs', config('app.cache_time'), function () {
                return FAQ::active()->hosting()->get();
            }),
        ];

        return view('website.hosting', compact('data'));
    }
}
