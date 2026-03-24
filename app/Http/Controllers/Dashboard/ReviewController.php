<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreRequest;
use App\Http\Requests\Review\UpdateRequest;
use App\Models\Review;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Review::class;

    public function index()
    {
        $this->authorize('viewAny', Review::class);
        $reviews = Review::withTrashed()->latest()->paginate(15);

        $statusCounts = Review::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        $pendingCount = (int) ($statusCounts['pending'] ?? 0);
        $approvedCount = (int) ($statusCounts['approved'] ?? 0);
        $rejectedCount = (int) ($statusCounts['rejected'] ?? 0);

        return view('dashboard.reviews.index', compact('reviews', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function create()
    {
        $this->authorize('create', Review::class);
        return view('dashboard.reviews.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Review::class);
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

        return redirect()->route('dashboard.reviews.show', $review)->withSuccess(__('messages.type_created', ['type' => __('main.review')]));
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);
        return view('dashboard.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        return view('dashboard.reviews.edit', compact('review'));
    }

    public function update(UpdateRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Handle photo update
        if ($request->hasFile('photo')) {
            if ($review->photo) {
                Storage::disk('public')->delete($review->photo);
            }
            $this->uploadSinglePhoto($request, $review, 'photo', 'reviews/photos');
        }

        $review->update($validated);

        return redirect()->route('dashboard.reviews.show', $review)->withSuccess(__('messages.type_updated', ['type' => __('main.review')]));
    }

    public function destroy(Review $review)
    {
        return $this->destroyModel($review, 'reviews');
    }
}
