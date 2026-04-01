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
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $this->parseKeywords($request->input("keywords_{$lang}") ?? ''),
            ];
        }

        $validated['translations'] = $translations;
        $programmingSystems = ProgrammingSystem::create($validated);

        if ($request->hasFile('icon')) {
            $this->uploadSinglePhoto($request, $programmingSystems, 'icon', 'programming-systems/icon');
        }
        if ($request->hasFile('images')) {
            $this->uploadFiles($request, $programmingSystems, 'images', 'programming-systems/images');
        }

        return $programmingSystems
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.programming_system')]))
                : redirect()->route('dashboard.programming-systems.index')->withSuccess(__('messages.type_created', ['type' => __('main.programming_system')])))
            : redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_creation_failed', ['type' => __('main.programming_system')]));
    }

    public function show($id)
    {
        $programmingSystem = ProgrammingSystem::find($id);
        if (!$programmingSystem)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('view', $programmingSystem);
        return view('dashboard.programming-systems.show', compact('programmingSystem'));
    }

    public function edit($id)
    {
        $programmingSystem = ProgrammingSystem::find($id);
        if (!$programmingSystem)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('update', $programmingSystem);
        return view('dashboard.programming-systems.edit', compact('programmingSystem'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $programmingSystem = ProgrammingSystem::find($id);
        if (!$programmingSystem)
            return redirect()->route('dashboard.programming-systems.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_system')]));
        $this->authorize('update', $programmingSystem);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'name' => $request->input("name_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $this->parseKeywords($request->input("keywords_{$lang}") ?? ''),
            ];
        }

        $validated['translations'] = $translations;
        $updated = $programmingSystem->update($validated);

        if ($request->hasFile('icon')) {
            $this->uploadSinglePhoto($request, $programmingSystem, 'icon', 'programming-systems/icon');
        }

        // Handle removed images - convert paths to indexes
        if ($request->has('removed_images') && !empty($request->input('removed_images'))) {
            $removedPaths = json_decode($request->input('removed_images'), true) ?? [];
            if (!empty($removedPaths)) {
                // Get current images
                $currentImages = $programmingSystem->images ?? [];
                // Find indexes of paths to remove
                $indexes = [];
                foreach ($removedPaths as $path) {
                    $index = array_search($path, $currentImages);
                    if ($index !== false) {
                        $indexes[] = $index;
                    }
                }
                // Delete by indexes
                if (!empty($indexes)) {
                    $this->deleteFiles($programmingSystem, $indexes, 'images');
                }
            }
        }

        if ($request->hasFile('images')) {
            $this->uploadFiles($request, $programmingSystem, 'images', 'programming-systems/images');
        }

        return $updated
            ? redirect()->route('dashboard.programming-systems.index')->withSuccess(__('messages.type_updated', ['type' => __('main.programming_system')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.programming_system')]));
    }

    public function destroy(ProgrammingSystem $programmingSystem)
    {
        return $this->destroyModel($programmingSystem, 'programming-systems');
    }

    /**
     * Parse keywords from Tagify format to simple array of strings
     * Tagify format: [{"value":"keyword1"}, {"value":"keyword2"}]
     * Desired format: ["keyword1", "keyword2"]
     */
    private function parseKeywords($keywords)
    {
        if (empty($keywords)) {
            return [];
        }

        // If it's a string, try to decode as JSON
        if (is_string($keywords)) {
            // First try to parse as JSON (Tagify format)
            $decoded = json_decode($keywords, true);

            if (is_array($decoded)) {
                // Extract values from Tagify objects
                $result = [];
                foreach ($decoded as $item) {
                    if (is_array($item) && isset($item['value'])) {
                        $result[] = $item['value'];
                    } else if (is_string($item)) {
                        // If it's already a string, add it directly
                        $result[] = $item;
                    }
                }
                return !empty($result) ? $result : [];
            }

            // If JSON decode failed, treat as comma-separated string
            return array_filter(array_map('trim', explode(',', $keywords)));
        }

        // If it's already an array, return as is
        if (is_array($keywords)) {
            return $keywords;
        }

        return [];
    }
}
