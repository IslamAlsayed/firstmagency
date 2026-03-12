<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ProjectController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Project::class;

    public function index()
    {
        $this->authorize('viewAny', Project::class);
        $projects = Project::with(['creator'])->latest()->paginate(15);
        return view('dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        return view('dashboard.projects.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Project::class);
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
        $project = Project::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $project, 'image', 'projects');
        }

        return $project
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.project_created'))
                : redirect()->route('dashboard.projects.index')->withSuccess(__('messages.type_created', ['type' => __('main.project')])))
            : redirect()->route('dashboard.projects.index')->withError(__('messages.type_creation_failed', ['type' => __('main.project')]));
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (!$project)
            return redirect()->route('dashboard.projects.index')->withError(__('messages.type_not_found', ['type' => __('main.project')]));
        $this->authorize('view', $project);
        return view('dashboard.projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::find($id);
        if (!$project)
            return redirect()->route('dashboard.projects.index')->withError(__('messages.type_not_found', ['type' => __('main.project')]));
        $this->authorize('update', $project);
        return view('dashboard.projects.edit', compact('project'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $project = Project::find($id);
        if (!$project)
            return redirect()->route('dashboard.projects.index')->withError(__('messages.type_not_found', ['type' => __('main.project')]));
        $this->authorize('update', $project);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'name' => $request->input("name_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $project->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $project, 'image', 'projects');
        }

        return $updated
            ? redirect()->route('dashboard.projects.index')->withSuccess(__('messages.type_updated', ['type' => __('main.project')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.project')]));
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project)
            return redirect()->route('dashboard.projects.index')->withError(__('messages.type_not_found', ['type' => __('main.project')]));

        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('dashboard.projects.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.project')]));
    }
}
