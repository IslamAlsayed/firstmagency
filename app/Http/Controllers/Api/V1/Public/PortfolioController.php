<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PortfolioResource;
use App\Models\Portfolio;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 15), 50);
        $items = Portfolio::active()->orderBy('order')->paginate($perPage);

        return $this->paginatedResponse($items, fn($p) => new PortfolioResource($p));
    }

    public function show(int $id): JsonResponse
    {
        $item = Portfolio::active()->find($id);

        if (! $item) {
            return $this->notFoundResponse('Portfolio item not found.');
        }

        return $this->successResponse(new PortfolioResource($item));
    }
}
