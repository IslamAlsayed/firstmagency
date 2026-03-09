<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlatformManagement\StoreRequest;
use App\Http\Requests\PlatformManagement\UpdateRequest;
use App\Models\PlatformManagement;
use App\Traits\GlobalDestroyTrait;

class PlatformManagementController extends Controller
{
    use GlobalDestroyTrait;

    protected $modelClass = PlatformManagement::class;

    public function index()
    {
        $this->authorize('viewAny', PlatformManagement::class);
        $platformManagements = PlatformManagement::with(['creator'])->latest()->paginate(15);
        return view('dashboard.platform-management.index', compact('platformManagements'));
    }

    public function create()
    {
        $this->authorize('create', PlatformManagement::class);
        return view('dashboard.platform-management.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', PlatformManagement::class);
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
        $platformManagement = PlatformManagement::create($validated);

        return $platformManagement
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.platform_management')]))
                : redirect()->route('dashboard.platform-management.index')->withSuccess(__('messages.type_created', ['type' => __('main.platform_management')])))
            : redirect()->route('dashboard.platform-management.index')->withError(__('messages.type_creation_failed', ['type' => __('main.platform_management')]));
    }

    public function show($id)
    {
        $platformManagement = PlatformManagement::find($id);
        if (!$platformManagement)
            return redirect()->route('dashboard.platform-management.index')->withError(__('messages.type_not_found', ['type' => __('main.platform_management')]));
        $this->authorize('view', $platformManagement);
        return view('dashboard.platform-management.show', compact('platformManagement'));
    }

    public function edit($id)
    {
        $platformManagement = PlatformManagement::find($id);
        if (!$platformManagement)
            return redirect()->route('dashboard.platform-management.index')->withError(__('messages.type_not_found', ['type' => __('main.platform_management')]));
        $this->authorize('update', $platformManagement);
        return view('dashboard.platform-management.edit', compact('platformManagement'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $platformManagement = PlatformManagement::find($id);
        if (!$platformManagement)
            return redirect()->route('dashboard.platform-management.index')->withError(__('messages.type_not_found', ['type' => __('main.platform_management')]));
        $this->authorize('update', $platformManagement);

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
        $updated = $platformManagement->update($validated);

        return $updated
            ? redirect()->route('dashboard.platform-management.index')->withSuccess(__('messages.type_updated', ['type' => __('main.platform_management')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.platform_management')]));
    }
}
