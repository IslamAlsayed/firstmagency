<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardsAndSystem\StoreRequest;
use App\Http\Requests\DashboardsAndSystem\UpdateRequest;
use App\Models\DashboardsAndSystem;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class DashboardsAndSystemController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = DashboardsAndSystem::class;

    public function index()
    {
        $this->authorize('viewAny', DashboardsAndSystem::class);
        $dashboardsAndSystems = DashboardsAndSystem::with(['creator'])->latest()->paginate(15);
        $allItems = DashboardsAndSystem::count() ?? 0;
        $operatingSystemsCount = DashboardsAndSystem::operatingSystems()->count() ?? 0;
        $dashboardsAndAppsCount = DashboardsAndSystem::dashboardsApps()->count() ?? 0;
        return view('dashboard.dashboards-and-systems.index', compact('dashboardsAndSystems', 'allItems', 'operatingSystemsCount', 'dashboardsAndAppsCount'));
    }

    public function create()
    {
        $this->authorize('create', DashboardsAndSystem::class);
        return view('dashboard.dashboards-and-systems.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', DashboardsAndSystem::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        $validated['type'] = 'dashboard-app';

        // Build translations array from form inputs
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $dashboardsAndSystem = DashboardsAndSystem::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $dashboardsAndSystem, 'image', 'dashboards-and-systems');
        }

        return $dashboardsAndSystem
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.dashboards_and_app')]))
                : redirect()->route('dashboard.dashboards-and-systems.index')->withSuccess(__('messages.type_created', ['type' => __('main.dashboards_and_app')])))
            : redirect()->route('dashboard.dashboards-and-systems.index')->withError(__('messages.type_creation_failed', ['type' => __('main.dashboards_and_app')]));
    }

    public function show($id)
    {
        $dashboardsAndSystem = DashboardsAndSystem::dashboardsApps()->find($id);
        if (!$dashboardsAndSystem)
            return redirect()->route('dashboard.dashboards-and-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.dashboards_and_app')]));
        $this->authorize('view', $dashboardsAndSystem);
        return view('dashboard.dashboards-and-systems.show', compact('dashboardsAndSystem'));
    }

    public function edit($id)
    {
        $dashboardsAndSystem = DashboardsAndSystem::dashboardsApps()->find($id);
        if (!$dashboardsAndSystem)
            return redirect()->route('dashboard.dashboards-and-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.dashboards_and_app')]));
        $this->authorize('update', $dashboardsAndSystem);
        return view('dashboard.dashboards-and-systems.edit', compact('dashboardsAndSystem'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $dashboardsAndSystem = DashboardsAndSystem::dashboardsApps()->find($id);
        if (!$dashboardsAndSystem)
            return redirect()->route('dashboard.dashboards-and-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.dashboards_and_app')]));
        $this->authorize('update', $dashboardsAndSystem);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        unset($validated['title_ar'], $validated['title_en']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($dashboardsAndSystem->image && file_exists(public_path('storage/' . $dashboardsAndSystem->image))) {
                unlink(public_path('storage/' . $dashboardsAndSystem->image));
            }
            $this->uploadSinglePhoto($request, $dashboardsAndSystem, 'image', 'dashboards-and-systems');
        }

        $updated = $dashboardsAndSystem->update($validated);

        return $updated
            ? redirect()->route('dashboard.dashboards-and-systems.show', $dashboardsAndSystem->id)->withSuccess(__('messages.type_updated', ['type' => __('main.dashboards_and_app')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.dashboards_and_app')]));
    }
}
