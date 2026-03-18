<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgrammingSystem\StoreRequest;
use App\Http\Requests\ProgrammingSystem\UpdateRequest;
use App\Models\ProgrammingSystem;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ProgrammingSystemController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = ProgrammingSystem::class;

    public function index()
    {
        $this->authorize('viewAny', ProgrammingSystem::class);
        $programmingSystems = ProgrammingSystem::with(['creator'])->latest()->paginate(15);
        return view('dashboard.programming-systems.index', compact('programmingSystems'));
    }

    public function create()
    {
        $this->authorize('create', ProgrammingSystem::class);
        return view('dashboard.programming-systems.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', ProgrammingSystem::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'name' => $request->input("name_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $programmingSystems = ProgrammingSystem::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programmingSystems, 'image', 'programmings');
        }

        return $programmingSystems
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.programming_system')]))
                : redirect()->route('dashboard.programming-systems.index')->withSuccess(__('messages.type_created', ['type' => __('main.programming_system')])))
            : redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_creation_failed', ['type' => __('main.programming_system')]));
    }

    public function show($id)
    {
        $programmingSystems = ProgrammingSystem::find($id);
        if (!$programmingSystems)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('view', $programmingSystems);
        return view('dashboard.programming-systems.show', compact('programmingSystems'));
    }

    public function edit($id)
    {
        $programmingSystems = ProgrammingSystem::find($id);
        if (!$programmingSystems)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('update', $programmingSystems);
        return view('dashboard.programming-systems.edit', compact('programmingSystems'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $programmingSystems = ProgrammingSystem::find($id);
        if (!$programmingSystems)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('update', $programmingSystems);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'name' => $request->input("name_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $programmingSystems->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programmingSystems, 'image', 'programmings');
        }

        return $updated
            ? redirect()->route('dashboard.programming-systems.index')->withSuccess(__('messages.type_updated', ['type' => __('main.programming_system')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.programming_system')]));
    }
}
