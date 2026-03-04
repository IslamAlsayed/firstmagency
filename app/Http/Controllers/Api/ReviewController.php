<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreRequest;
use App\Models\Review;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    use PhotoUploadTrait;

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'pending';
        $validated['created_by'] = getActiveUserId();

        // Extract audio before creating review
        $audioBase64 = $validated['audio'] ?? null;
        unset($validated['audio']);

        // Create review without audio
        $review = Review::create($validated);

        // Handle audio upload (convert base64 to file)
        if ($audioBase64) {
            $audioContent = base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $audioBase64));
            $filename = 'review_' . time() . '.wav';
            $audioPath = "uploads/reviews/{$review->id}/audio/{$filename}";
            Storage::disk('public')->put($audioPath, $audioContent);
            $review->update(['audio' => $audioPath]);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $review, 'photo', 'reviews', 'photo');
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('main.created_successfully'),
            'data' => $review,
        ], 201);
    }
}
