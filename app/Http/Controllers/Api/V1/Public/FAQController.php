<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FAQResource;
use App\Models\FAQ;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = FAQ::query()->where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        $faqs = $query->orderBy('order')->get();

        return $this->successResponse(FAQResource::collection($faqs));
    }
}
