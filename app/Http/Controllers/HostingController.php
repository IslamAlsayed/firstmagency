<?php

namespace App\Http\Controllers;

use App\Models\DashboardsAndSystem;
use App\Models\FAQ;
use App\Models\FeaturesHosting;
use App\Models\HostingPackage;
use Illuminate\Support\Facades\Cache;

class HostingController extends Controller
{
    public function index()
    {
        $data = [
            'features_hosting' => Cache::remember('hosting_features', 1800, function () {
                return FeaturesHosting::ordered()->get();
            }),

            'packages' => [
                'hosting' => Cache::remember('hosting_packages', 1800, function () {
                    return HostingPackage::hostingPackages()->get();
                }),

                'reseller' => Cache::remember('hosting_reseller_packages', 1800, function () {
                    return HostingPackage::resellerPackages()->get();
                }),

                'vps' => Cache::remember('hosting_vps_packages', 1800, function () {
                    return HostingPackage::vpsPackages()->get();
                }),

                'server' => Cache::remember('hosting_server_packages', 1800, function () {
                    return HostingPackage::serverPackages()->get();
                }),
            ],

            'operating' => [
                'systems' => Cache::remember('operating_systems', 1800, function () {
                    return DashboardsAndSystem::operatingSystems()->get();
                }),

                'apps' => Cache::remember('dashboards_apps', 1800, function () {
                    return DashboardsAndSystem::dashboardsApps()->get();
                }),
            ],

            'faqs' => Cache::remember('hosting_faqs', 1800, function () {
                return FAQ::active()->hosting()->get();
            }),
        ];

        return view('website.hosting', compact('data'));
    }
}
