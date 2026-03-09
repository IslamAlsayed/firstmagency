<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineWork\StoreRequest;
use App\Http\Requests\LineWork\UpdateRequest;
use App\Models\LineWork;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class LineWorkController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = LineWork::class;

    public function index()
    {
        $this->authorize('viewAny', LineWork::class);
        $lineWorks = LineWork::with(['creator'])->latest()->paginate(15);
        return view('dashboard.line-works.index', compact('lineWorks'));
    }

    public function create()
    {
        $this->authorize('create', LineWork::class);
        return view('dashboard.line-works.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', LineWork::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'name' => $request->input("name_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $lineWork = LineWork::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $lineWork, 'image', 'line-works');
        }

        return $lineWork
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.line_work_created'))
                : redirect()->route('dashboard.line-works.index')->withSuccess(__('messages.type_created', ['type' => __('main.line_work')])))
            : redirect()->route('dashboard.line-works.index')->withError(__('messages.type_creation_failed', ['type' => __('main.line_work')]));
    }

    public function show($id)
    {
        $lineWork = LineWork::find($id);
        if (!$lineWork)
            return redirect()->route('dashboard.line-works.index')->withError(__('messages.type_not_found', ['type' => __('main.line_work')]));
        $this->authorize('view', $lineWork);
        return view('dashboard.line-works.show', compact('lineWork'));
    }

    public function edit($id)
    {
        $lineWork = LineWork::find($id);
        if (!$lineWork)
            return redirect()->route('dashboard.line-works.index')->withError(__('messages.type_not_found', ['type' => __('main.line_work')]));
        $this->authorize('update', $lineWork);
        return view('dashboard.line-works.edit', compact('lineWork'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $lineWork = LineWork::find($id);
        if (!$lineWork)
            return redirect()->route('dashboard.line-works.index')->withError(__('messages.type_not_found', ['type' => __('main.line_work')]));
        $this->authorize('update', $lineWork);

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
        $updated = $lineWork->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $lineWork, 'image', 'line-works');
        }

        return $updated
            ? redirect()->route('dashboard.line-works.index')->withSuccess(__('messages.type_updated', ['type' => __('main.line_work')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.line_work')]));
    }
}