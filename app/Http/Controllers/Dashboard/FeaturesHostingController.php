<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeaturesHosting\StoreRequest;
use App\Http\Requests\FeaturesHosting\UpdateRequest;
use App\Models\FeaturesHosting;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class FeaturesHostingController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = FeaturesHosting::class;

    public function index()
    {
        $this->authorize('viewAny', FeaturesHosting::class);
        $featuresHosting = FeaturesHosting::with(['creator'])->latest()->paginate(15);
        return view('dashboard.features-hosting.index', compact('featuresHosting'));
    }

    public function create()
    {
        $this->authorize('create', FeaturesHosting::class);
        return view('dashboard.features-hosting.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', FeaturesHosting::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        unset($validated['title_ar'], $validated['title_en'], $validated['description_ar'], $validated['description_en']);

        $featuresHosting = FeaturesHosting::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $featuresHosting, 'image', 'features-hosting');
        }

        return $featuresHosting
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.features_hosting')]))
                : redirect()->route('dashboard.features-hosting.index')->withSuccess(__('messages.type_created', ['type' => __('main.features_hosting')])))
            : redirect()->route('dashboard.features-hosting.index')->withError(__('messages.type_creation_failed', ['type' => __('main.features_hosting')]));
    }

    public function show($id)
    {
        $featuresHosting = FeaturesHosting::find($id);
        if (!$featuresHosting)
            return redirect()->route('dashboard.features-hosting.index')->withError(__('messages.type_not_found', ['type' => __('main.features_hosting')]));
        $this->authorize('view', $featuresHosting);
        return view('dashboard.features-hosting.show', compact('featuresHosting'));
    }

    public function edit($id)
    {
        $featuresHosting = FeaturesHosting::find($id);
        if (!$featuresHosting)
            return redirect()->route('dashboard.features-hosting.index')->withError(__('messages.type_not_found', ['type' => __('main.features_hosting')]));
        $this->authorize('update', $featuresHosting);
        return view('dashboard.features-hosting.edit', compact('featuresHosting'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $featuresHosting = FeaturesHosting::find($id);
        if (!$featuresHosting)
            return redirect()->route('dashboard.features-hosting.index')->withError(__('messages.type_not_found', ['type' => __('main.features_hosting')]));
        $this->authorize('update', $featuresHosting);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        unset($validated['title_ar'], $validated['title_en'], $validated['description_ar'], $validated['description_en']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($featuresHosting->image && file_exists(public_path('storage/' . $featuresHosting->image))) {
                unlink(public_path('storage/' . $featuresHosting->image));
            }
            $this->uploadSinglePhoto($request, $featuresHosting, 'image', 'features-hosting');
        }

        $updated = $featuresHosting->update($validated);

        return $updated
            ? redirect()->route('dashboard.features-hosting.show', $featuresHosting->id)->withSuccess(__('messages.type_updated', ['type' => __('main.features_hosting')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.features_hosting')]));
    }
}
