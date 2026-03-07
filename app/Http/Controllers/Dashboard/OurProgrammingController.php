<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OurProgramming\StoreRequest;
use App\Http\Requests\OurProgramming\UpdateRequest;
use App\Models\OurProgramming;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class OurProgrammingController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = OurProgramming::class;

    public function index()
    {
        $this->authorize('viewAny', OurProgramming::class);
        $ourProgrammings = OurProgramming::with(['creator'])->latest()->paginate(15);
        return view('dashboard.our-programmings.index', compact('ourProgrammings'));
    }

    public function create()
    {
        $this->authorize('create', OurProgramming::class);
        return view('dashboard.our-programmings.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', OurProgramming::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        $ourProgramming = OurProgramming::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $ourProgramming, 'image', 'our-programmings');
        }

        return $ourProgramming
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.our_programming_created'))
                : redirect()->route('dashboard.our-programmings.index')->withSuccess(__('messages.type_created', ['type' => __('main.our_programming')])))
            : redirect()->route('dashboard.our-programmings.index')->withError(__('messages.type_creation_failed', ['type' => __('main.our_programming')]));
    }

    public function show($id)
    {
        $ourProgramming = OurProgramming::find($id);
        if (!$ourProgramming)
            return redirect()->route('dashboard.our-programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.our_programming')]));
        $this->authorize('view', $ourProgramming);
        return view('dashboard.our-programmings.show', compact('ourProgramming'));
    }

    public function edit($id)
    {
        $ourProgramming = OurProgramming::find($id);
        if (!$ourProgramming)
            return redirect()->route('dashboard.our-programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.our_programming')]));
        $this->authorize('update', $ourProgramming);
        return view('dashboard.our-programmings.edit', compact('ourProgramming'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $ourProgramming = OurProgramming::find($id);
        if (!$ourProgramming)
            return redirect()->route('dashboard.our-programmings.index')->withError(__('messages.type_not_found', ['type' => __('main.our_programming')]));
        $this->authorize('update', $ourProgramming);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        $updated = $ourProgramming->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $ourProgramming, 'image', 'our-programmings');
        }

        return $updated
            ? redirect()->route('dashboard.our-programmings.show', $ourProgramming->id)->withSuccess(__('messages.type_updated', ['type' => __('main.our_programming')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.our_programming')]));
    }
}