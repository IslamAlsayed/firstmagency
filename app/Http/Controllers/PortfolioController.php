<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = Cache::remember('home_portfolio', 1800, function () {
            return Portfolio::active()->orderBy('order')->get();
        });

        return view('website.portfolio', compact('portfolio'));
    }

    public function show($id, $slug)
    {
        $portfolio = Portfolio::find($id);
        if (!$portfolio)
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.project')]));

        $similarProjects = [];
        $tags = is_array($portfolio->tags) ? $portfolio->tags : [];

        if (!empty($tags) && count($tags) > 0) {
            $similarProjects = Portfolio::where('id', '!=', $portfolio->id)
                ->active()->orderBy('order')->limit(3)->get()
                ->filter(function ($project) use ($tags) {
                    $projectTags = is_array($project->tags) ? $project->tags : [];
                    $commonTags = array_intersect($projectTags, $tags);
                    return count($commonTags) > 0;
                })->values();
        }

        return view('website.workShow', compact('portfolio', 'similarProjects'));
    }
}