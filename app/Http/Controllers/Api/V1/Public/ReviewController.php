<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreRequest;
use App\Http\Resources\Api\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponseTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    use ApiResponseTrait, PhotoUploadTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 15), 50);
        $reviews = Review::approved()->orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($reviews, fn($r) => new ReviewResource($r));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['status'] = 'pending';

        $audioBase64 = $validated['audio'] ?? null;
        unset($validated['audio']);

        $review = Review::create($validated);

        if ($audioBase64) {
            $audioContent = base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $audioBase64));
            $filename = 'review_' . time() . '.wav';
            $audioPath = "uploads/reviews/{$review->id}/audio/{$filename}";
            Storage::disk('public')->put($audioPath, $audioContent);
            $review->update(['audio' => $audioPath]);
        }

        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $review, 'photo', 'reviews', 'photo');
        }

        return $this->successResponse(new ReviewResource($review), 'Review submitted successfully.', 201);
    }
}
