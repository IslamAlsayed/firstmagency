<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkUsStep\StoreRequest;
use App\Http\Requests\WorkUsStep\UpdateRequest;
use App\Models\WorkUsStep;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class WorkUsStepController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = WorkUsStep::class;

    public function index()
    {
        $this->authorize('viewAny', WorkUsStep::class);
        $workUsSteps = WorkUsStep::with(['creator'])->latest()->paginate(15);
        return view('dashboard.work-us-step.index', compact('workUsSteps'));
    }

    public function create()
    {
        $this->authorize('create', WorkUsStep::class);
        return view('dashboard.work-us-step.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', WorkUsStep::class);
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
        $workUsStep = WorkUsStep::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $workUsStep, 'image', 'work-us-step');
        }

        return $workUsStep
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.work_us_step')]))
                : redirect()->route('dashboard.work-us-step.index')->withSuccess(__('messages.type_created', ['type' => __('main.work_us_step')])))
            : redirect()->route('dashboard.work-us-step.index')->withError(__('messages.type_creation_failed', ['type' => __('main.work_us_step')]));
    }

    public function show($id)
    {
        $workUsStep = WorkUsStep::find($id);
        if (!$workUsStep)
            return redirect()->route('dashboard.work-us-step.index')->withError(__('messages.type_not_found', ['type' => __('main.work_us_step')]));
        $this->authorize('view', $workUsStep);
        return view('dashboard.work-us-step.show', compact('workUsStep'));
    }

    public function edit($id)
    {
        $workUsStep = WorkUsStep::find($id);
        if (!$workUsStep)
            return redirect()->route('dashboard.work-us-step.index')->withError(__('messages.type_not_found', ['type' => __('main.work_us_step')]));
        $this->authorize('update', $workUsStep);
        return view('dashboard.work-us-step.edit', compact('workUsStep'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $workUsStep = WorkUsStep::find($id);
        if (!$workUsStep)
            return redirect()->route('dashboard.work-us-step.index')->withError(__('messages.type_not_found', ['type' => __('main.work_us_step')]));
        $this->authorize('update', $workUsStep);

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
        $updated = $workUsStep->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $workUsStep, 'image', 'work-us-step');
        }

        return $updated
            ? redirect()->route('dashboard.work-us-step.index')->withSuccess(__('messages.type_updated', ['type' => __('main.work_us_step')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.work_us_step')]));
    }

    public function destroy(WorkUsStep $workUsStep)
    {
        return $this->destroyModel($workUsStep, 'work-us-step');
    }
}
