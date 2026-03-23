<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketingPackage\StoreRequest;
use App\Http\Requests\MarketingPackage\UpdateRequest;
use App\Models\MarketingPackage;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class MarketingPackageController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = MarketingPackage::class;

    public function index()
    {
        $this->authorize('viewAny', MarketingPackage::class);
        $marketingPackages = MarketingPackage::with(['creator'])->latest()->paginate(15);
        return view('dashboard.marketing-packages.index', compact('marketingPackages'));
    }

    public function create()
    {
        $this->authorize('create', MarketingPackage::class);
        return view('dashboard.marketing-packages.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', MarketingPackage::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = ['title' => $request->input("title_{$lang}") ?? ''];
        }

        $validated['translations'] = $translations;

        // Build features array
        $features = [];
        if ($request->has('feature_title_en')) {
            $featureTitlesEn = $request->input('feature_title_en', []);

            foreach ($featureTitlesEn as $index => $title) {
                if (!empty($title)) {
                    $features[] = [
                        'title_en' => $title,
                        'title_ar' => $request->input("feature_title_ar.$index") ?? '',
                    ];
                }
            }
        }

        $validated['features'] = $features;
        $marketingPackage = MarketingPackage::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $marketingPackage, 'image', 'marketing-package');
        }

        return $marketingPackage
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.marketing_package')]))
                : redirect()->route('dashboard.marketing-packages.index')->withSuccess(__('messages.type_created', ['type' => __('main.marketing_package')])))
            : redirect()->route('dashboard.marketing-packages.index')->withError(__('messages.type_creation_failed', ['type' => __('main.marketing_package')]));
    }

    public function show($id)
    {
        $marketingPackage = MarketingPackage::find($id);
        if (!$marketingPackage)
            return redirect()->route('dashboard.marketing-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.marketing_package')]));
        $this->authorize('view', $marketingPackage);
        return view('dashboard.marketing-packages.show', compact('marketingPackage'));
    }

    public function edit($id)
    {
        $marketingPackage = MarketingPackage::find($id);
        if (!$marketingPackage)
            return redirect()->route('dashboard.marketing-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.marketing_package')]));
        $this->authorize('update', $marketingPackage);
        return view('dashboard.marketing-packages.edit', compact('marketingPackage'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $marketingPackage = MarketingPackage::find($id);
        if (!$marketingPackage)
            return redirect()->route('dashboard.marketing-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.marketing_package')]));
        $this->authorize('update', $marketingPackage);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = ['title' => $request->input("title_{$lang}") ?? ''];
        }

        $validated['translations'] = $translations;

        // Build features array
        $features = [];
        if ($request->has('feature_title_en')) {
            $featureTitlesEn = $request->input('feature_title_en', []);

            foreach ($featureTitlesEn as $index => $title) {
                if (!empty($title)) {
                    $features[] = [
                        'title_en' => $title,
                        'title_ar' => $request->input("feature_title_ar.$index") ?? '',
                    ];
                }
            }
        }

        $validated['features'] = $features;
        $updated = $marketingPackage->update($validated);

        if ($request->input('remove_image') && $request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $updated, 'image', 'marketing-package');
        }

        return $updated
            ? redirect()->route('dashboard.marketing-packages.index')->withSuccess(__('messages.type_updated', ['type' => __('main.marketing_package')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.marketing_package')]));
    }

    public function destroy(MarketingPackage $marketingPackage)
    {
        return $this->destroyModel($marketingPackage, 'marketing-packages');
    }
}
