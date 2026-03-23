<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgrammingCategory\StoreRequest;
use App\Http\Requests\ProgrammingCategory\UpdateRequest;
use App\Models\ProgrammingCategory;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class ProgrammingCategoryController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = ProgrammingCategory::class;

    public function index()
    {
        $this->authorize('viewAny', ProgrammingCategory::class);
        $programmingCategories = ProgrammingCategory::with(['creator'])->latest()->paginate(15);
        return view('dashboard.programming-categories.index', compact('programmingCategories'));
    }

    public function create()
    {
        $this->authorize('create', ProgrammingCategory::class);
        return view('dashboard.programming-categories.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', ProgrammingCategory::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        $programmingCategory = ProgrammingCategory::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programmingCategory, 'image', 'programmings-categories');
        }

        return $programmingCategory
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.programming_category')]))
                : redirect()->route('dashboard.programming-categories.index')->withSuccess(__('messages.type_created', ['type' => __('main.programming_category')])))
            : redirect()->route('dashboard.programming-categories.index')->withError(__('messages.type_creation_failed', ['type' => __('main.programming_category')]));
    }

    public function show($id)
    {
        $programmingCategory = ProgrammingCategory::find($id);
        if (!$programmingCategory)
            return redirect()->route('dashboard.programming-categories.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_category')]));
        $this->authorize('view', $programmingCategory);
        return view('dashboard.programming-categories.show', compact('programmingCategory'));
    }

    public function edit($id)
    {
        $programmingCategory = ProgrammingCategory::find($id);
        if (!$programmingCategory)
            return redirect()->route('dashboard.programming-categories.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_category')]));
        $this->authorize('update', $programmingCategory);
        return view('dashboard.programming-categories.edit', compact('programmingCategory'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $programmingCategory = ProgrammingCategory::find($id);
        if (!$programmingCategory)
            return redirect()->route('dashboard.programming-categories.index')->withError(__('messages.type_not_found', ['type' => __('main.programming_category')]));
        $this->authorize('update', $programmingCategory);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        $updated = $programmingCategory->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $programmingCategory, 'image', 'programmings-categories');
        }

        return $updated
            ? redirect()->route('dashboard.programming-categories.show', $programmingCategory->id)->withSuccess(__('messages.type_updated', ['type' => __('main.programming_category')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.programming_category')]));
    }

    public function destroy(ProgrammingCategory $programmingCategory)
    {
        return $this->destroyModel($programmingCategory, 'programming-categories');
    }
}
