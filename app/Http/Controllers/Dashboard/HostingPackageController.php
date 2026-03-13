<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostingPackage\StoreRequest;
use App\Http\Requests\HostingPackage\UpdateRequest;
use App\Models\HostingPackage;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class HostingPackageController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = HostingPackage::class;

    public function index()
    {
        $this->authorize('viewAny', HostingPackage::class);
        $hostingPackages = HostingPackage::with(['creator'])->latest()->paginate(15);
        $allItems = HostingPackage::count() ?? 0;
        $hostingCount = HostingPackage::where('category', 'hosting')->count() ?? 0;
        $resellerCount = HostingPackage::where('category', 'reseller')->count() ?? 0;
        $vpsCount = HostingPackage::where('category', 'vps')->count() ?? 0;
        $serversCount = HostingPackage::where('category', 'servers')->count() ?? 0;
        return view('dashboard.hosting-packages.index', compact('hostingPackages', 'allItems', 'hostingCount', 'resellerCount', 'vpsCount', 'serversCount'));
    }

    public function create()
    {
        $this->authorize('create', HostingPackage::class);
        $categories = ['hosting', 'reseller', 'vps', 'servers'];
        return view('dashboard.hosting-packages.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', HostingPackage::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;

        // Build features array
        $features = [];
        if ($request->has('feature_title_en')) {
            $featureTitlesEn = $request->input('feature_title_en', []);
            $featureLabelsEn = $request->input('feature_label_en', []);

            foreach ($featureTitlesEn as $index => $title) {
                if (!empty($title)) {
                    $features[] = [
                        'title_en' => $title,
                        'label_en' => $featureLabelsEn[$index] ?? '',
                        'title_ar' => $request->input("feature_title_ar.$index") ?? '',
                        'label_ar' => $request->input("feature_label_ar.$index") ?? '',
                    ];
                }
            }
        }

        $validated['features'] = $features;
        $hostingPackage = HostingPackage::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $hostingPackage, 'image', 'hosting-packages');
        }

        return $hostingPackage
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.hosting_package')]))
                : redirect()->route('dashboard.hosting-packages.index')->withSuccess(__('messages.type_created', ['type' => __('main.hosting_package')])))
            : redirect()->route('dashboard.hosting-packages.index')->withError(__('messages.type_creation_failed', ['type' => __('main.hosting_package')]));
    }

    public function show($id)
    {
        $hostingPackage = HostingPackage::find($id);
        if (!$hostingPackage)
            return redirect()->route('dashboard.hosting-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_package')]));
        $this->authorize('view', $hostingPackage);
        return view('dashboard.hosting-packages.show', compact('hostingPackage'));
    }

    public function edit($id)
    {
        $hostingPackage = HostingPackage::find($id);
        if (!$hostingPackage)
            return redirect()->route('dashboard.hosting-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_package')]));
        $this->authorize('update', $hostingPackage);
        $categories = ['hosting', 'reseller', 'vps', 'servers'];
        return view('dashboard.hosting-packages.edit', compact('hostingPackage', 'categories'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $hostingPackage = HostingPackage::find($id);
        if (!$hostingPackage)
            return redirect()->route('dashboard.hosting-packages.index')->withError(__('messages.type_not_found', ['type' => __('main.hosting_package')]));
        $this->authorize('update', $hostingPackage);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;

        // Build features array
        $features = [];
        if ($request->has('feature_title_en')) {
            $featureTitlesEn = $request->input('feature_title_en', []);
            $featureLabelsEn = $request->input('feature_label_en', []);

            foreach ($featureTitlesEn as $index => $title) {
                if (!empty($title)) {
                    $features[] = [
                        'title_en' => $title,
                        'label_en' => $featureLabelsEn[$index] ?? '',
                        'title_ar' => $request->input("feature_title_ar.$index") ?? '',
                        'label_ar' => $request->input("feature_label_ar.$index") ?? '',
                    ];
                }
            }
        }

        $validated['features'] = $features;

        if ($request->hasFile('image')) {
            if ($hostingPackage->image && file_exists(public_path('storage/' . $hostingPackage->image))) {
                unlink(public_path('storage/' . $hostingPackage->image));
            }
            $this->uploadSinglePhoto($request, $hostingPackage, 'image', 'hosting-packages');
        }

        $updated = $hostingPackage->update($validated);

        return $updated
            ? redirect()->route('dashboard.hosting-packages.show', $hostingPackage->id)->withSuccess(__('messages.type_updated', ['type' => __('main.hosting_package')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.hosting_package')]));
    }
}