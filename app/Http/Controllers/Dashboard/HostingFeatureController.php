<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostingFeature\StoreRequest;
use App\Http\Requests\HostingFeature\UpdateRequest;
use App\Models\HostingFeature;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class HostingFeatureController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = HostingFeature::class;

    public function index()
    {
        $this->authorize('viewAny', HostingFeature::class);
        $hostingFeatures = HostingFeature::with(['creator'])->latest()->paginate(15);
        $allItems = HostingFeature::count() ?? 0;
        $allItemActive = HostingFeature::active()->count() ?? 0;
        return view('dashboard.hosting-features.index', compact('hostingFeatures', 'allItems', 'allItemActive'));
    }

    public function create()
    {
        $this->authorize('create', HostingFeature::class);
        return view('dashboard.hosting-features.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', HostingFeature::class);
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

        $hostingFeatures = HostingFeature::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $hostingFeatures, 'image', 'hosting-features');
        }

        return $hostingFeatures
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.hosting_feature')]))
                : redirect()->route('dashboard.hosting-features.index')->withSuccess(__('messages.type_created', ['type' => __('main.hosting_feature')])))
            : redirect()->route('dashboard.hosting-features.index')->withError(__('messages.type_creation_failed', ['type' => __('main.hosting_feature')]));
    }

    public function show($id)
    {
        $hostingFeatures = HostingFeature::find($id);
        if (!$hostingFeatures)
            return redirect()->route('dashboard.hosting-features.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_feature')]));
        $this->authorize('view', $hostingFeatures);
        return view('dashboard.hosting-features.show', compact('hostingFeatures'));
    }

    public function edit($id)
    {
        $hostingFeatures = HostingFeature::find($id);
        if (!$hostingFeatures)
            return redirect()->route('dashboard.hosting-features.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_feature')]));
        $this->authorize('update', $hostingFeatures);
        return view('dashboard.hosting-features.edit', compact('hostingFeatures'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $hostingFeatures = HostingFeature::find($id);
        if (!$hostingFeatures)
            return redirect()->route('dashboard.hosting-features.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_feature')]));
        $this->authorize('update', $hostingFeatures);

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
            if ($hostingFeatures->image && file_exists(public_path('storage/' . $hostingFeatures->image))) {
                unlink(public_path('storage/' . $hostingFeatures->image));
            }
            $this->uploadSinglePhoto($request, $hostingFeatures, 'image', 'hosting-features');
        }

        $updated = $hostingFeatures->update($validated);

        return $updated
            ? redirect()->route('dashboard.hosting-features.show', $hostingFeatures->id)->withSuccess(__('messages.type_updated', ['type' => __('main.hosting_feature')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.hosting_feature')]));
    }
}
