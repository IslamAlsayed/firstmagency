<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 20), 100);

        $query = Review::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reviews = $query->paginate($perPage);

        return $this->paginatedResponse($reviews, fn($r) => new ReviewResource($r));
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $review = Review::find($id);

        if (! $review) {
            return $this->notFoundResponse('Review not found.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $review->update($validated);

        return $this->successResponse(new ReviewResource($review), 'Review updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $review = Review::find($id);

        if (! $review) {
            return $this->notFoundResponse('Review not found.');
        }

        $review->delete();

        return $this->successResponse(null, 'Review deleted.');
    }
}
