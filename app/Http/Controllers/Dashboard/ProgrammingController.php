<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Programming\StoreRequest;
use App\Http\Requests\Programming\UpdateRequest;
use App\Models\Programming;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ProgrammingController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Programming::class;

    public function index()
    {
        $this->authorize('viewAny', Programming::class);
        $programmings = Programming::with(['creator'])->latest()->paginate(15);
        return view('dashboard.programmings.index', compact('programmings'));
    }

    public function create()
    {
        $this->authorize('create', Programming::class);
        return view('dashboard.programmings.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Programming::class);
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
        $programming = Programming::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programming, 'image', 'programmings');
        }

        return $programming
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.programming_created'))
                : redirect()->route('dashboard.programmings.index')->withSuccess(__('messages.type_created', ['type' => __('main.programming')])))
            : redirect()->route('dashboard.programmings.index')->withError(__('messages.type_creation_failed', ['type' => __('main.programming')]));
    }

    public function show($id)
    {
        $programming = Programming::find($id);
        if (!$programming)
            return redirect()->route('dashboard.programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.programming')]));
        $this->authorize('view', $programming);
        return view('dashboard.programmings.show', compact('programming'));
    }

    public function edit($id)
    {
        $programming = Programming::find($id);
        if (!$programming)
            return redirect()->route('dashboard.programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.programming')]));
        $this->authorize('update', $programming);
        return view('dashboard.programmings.edit', compact('programming'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $programming = Programming::find($id);
        if (!$programming)
            return redirect()->route('dashboard.programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.programming')]));
        $this->authorize('update', $programming);

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
        $updated = $programming->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programming, 'image', 'programmings');
        }

        return $updated
            ? redirect()->route('dashboard.programmings.index')->withSuccess(__('messages.type_updated', ['type' => __('main.programming')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.programming')]));
    }
}
