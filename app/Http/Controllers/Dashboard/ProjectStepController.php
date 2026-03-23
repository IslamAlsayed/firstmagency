<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStep\StoreRequest;
use App\Http\Requests\ProjectStep\UpdateRequest;
use App\Models\ProjectStep;
use App\Traits\GlobalDestroyTrait;

class ProjectStepController extends Controller
{
    use GlobalDestroyTrait;

    protected $modelClass = ProjectStep::class;

    public function index()
    {
        $this->authorize('viewAny', ProjectStep::class);
        $projectSteps = ProjectStep::with(['creator'])->latest()->paginate(15);
        return view('dashboard.project-steps.index', compact('projectSteps'));
    }

    public function create()
    {
        $this->authorize('create', ProjectStep::class);
        return view('dashboard.project-steps.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', ProjectStep::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];
        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $projectStep = ProjectStep::create($validated);

        return $projectStep
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.project_step')]))
                : redirect()->route('dashboard.project-steps.index')->withSuccess(__('messages.type_created', ['type' => __('main.project_step')])))
            : redirect()->route('dashboard.project-steps.index')->withError(__('messages.type_creation_failed', ['type' => __('main.project_step')]));
    }

    public function show($id)
    {
        $projectStep = ProjectStep::find($id);
        if (!$projectStep)
            return redirect()->route('dashboard.project-steps.index')->withError(__('messages.type_not_found', ['type' => __('main.project_step')]));
        $this->authorize('view', $projectStep);
        return view('dashboard.project-steps.show', compact('projectStep'));
    }

    public function edit($id)
    {
        $projectStep = ProjectStep::find($id);
        if (!$projectStep)
            return redirect()->route('dashboard.project-steps.index')->withError(__('messages.type_not_found', ['type' => __('main.project_step')]));
        $this->authorize('update', $projectStep);
        return view('dashboard.project-steps.edit', compact('projectStep'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $projectStep = ProjectStep::find($id);
        if (!$projectStep)
            return redirect()->route('dashboard.project-steps.index')->withError(__('messages.type_not_found', ['type' => __('main.project_step')]));
        $this->authorize('update', $projectStep);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $projectStep->update($validated);

        return $updated
            ? redirect()->route('dashboard.project-steps.show', $projectStep->id)->withSuccess(__('messages.type_updated', ['type' => __('main.project_step')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.project_step')]));
    }

    public function destroy(ProjectStep $projectStep)
    {
        return $this->destroyModel($projectStep, 'project-steps');
    }
}
