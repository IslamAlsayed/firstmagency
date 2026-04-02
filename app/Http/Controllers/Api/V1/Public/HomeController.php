<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticleResource;
use App\Http\Resources\Api\PortfolioResource;
use App\Http\Resources\Api\ProjectResource;
use App\Http\Resources\Api\ReviewResource;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use App\Models\WhyUs;
use App\Models\WorkUsStep;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        return $this->successResponse([
            'services'   => ServiceResource::collection(Service::active()->published()->orderBy('order')->get()),
            'reviews'    => ReviewResource::collection(Review::approved()->orderBy('created_at', 'desc')->limit(6)->get()),
            'why_us'     => WhyUs::active()->published()->ordered()->get()->map(fn($w) => [
                'id'          => $w->id,
                'slug'        => $w->slug,
                'image'       => $w->image ? asset('storage/' . $w->image) : null,
                'alt_text'    => $w->alt_text,
                'translations' => $w->translations,
            ]),
            'work_steps' => WorkUsStep::active()->published()->ordered()->get()->map(fn($s) => [
                'id'           => $s->id,
                'slug'         => $s->slug,
                'image'        => $s->image ? asset('storage/' . $s->image) : null,
                'translations' => $s->translations,
            ]),
            'partners'   => Partner::active()->published()->ordered()->get()->map(fn($p) => [
                'id'      => $p->id,
                'image'   => $p->image ? asset('storage/' . $p->image) : null,
                'website' => $p->website,
            ]),
            'projects'   => ProjectResource::collection(Project::active()->orderBy('order')->limit(6)->get()),
            'portfolio'  => PortfolioResource::collection(Portfolio::active()->orderBy('order')->limit(6)->get()),
        ]);
    }
}
