<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\OfficialDomain;
use App\Models\PestDomain;
use App\Models\WhyUs;
use Illuminate\Support\Facades\Cache;

class DomainController extends Controller
{
    public function index()
    {
        $data = [
            'pest_domains' => Cache::remember('pest_domains', 1800, function () {
                return PestDomain::active()->ordered()->get();
            }),

            'official_domains' => Cache::remember('official_domains', 1800, function () {
                return OfficialDomain::active()->ordered()->get();
            }),

            'why_us' => Cache::remember('domain_why_us', 1800, function () {
                return WhyUs::active()->ordered()->get();
            }),

            'faqs' => Cache::remember('domain_faqs', 1800, function () {
                return FAQ::active()->domains()->get();
            }),
        ];

        return view('website.domains', compact('data'));
    }
}
