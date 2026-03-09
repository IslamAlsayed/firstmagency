<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhyUs\StoreRequest;
use App\Http\Requests\WhyUs\UpdateRequest;
use App\Models\WhyUs;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class WhyUsController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = WhyUs::class;

    public function index()
    {
        $this->authorize('viewAny', WhyUs::class);
        $whyUs = WhyUs::with(['creator'])->latest()->paginate(15);
        return view('dashboard.why-us.index', compact('whyUs'));
    }

    public function create()
    {
        $this->authorize('create', WhyUs::class);
        return view('dashboard.why-us.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', WhyUs::class);
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
        $whyUs = WhyUs::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $whyUs, 'image', 'why-us');
        }

        return $whyUs
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.why_us')]))
                : redirect()->route('dashboard.why-us.index')->withSuccess(__('messages.type_created', ['type' => __('main.why_us')])))
            : redirect()->route('dashboard.why-us.index')->withError(__('messages.type_creation_failed', ['type' => __('main.why_us')]));
    }

    public function show($id)
    {
        $whyUs = WhyUs::find($id);
        if (!$whyUs)
            return redirect()->route('dashboard.why-us.index')->withError(__('messages.type_not_found', ['type' => __('main.why_us')]));
        $this->authorize('view', $whyUs);
        return view('dashboard.why-us.show', compact('whyUs'));
    }

    public function edit($id)
    {
        $whyUs = WhyUs::find($id);
        if (!$whyUs)
            return redirect()->route('dashboard.why-us.index')->withError(__('messages.type_not_found', ['type' => __('main.why_us')]));
        $this->authorize('update', $whyUs);
        return view('dashboard.why-us.edit', compact('whyUs'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $whyUs = WhyUs::find($id);
        if (!$whyUs)
            return redirect()->route('dashboard.why-us.index')->withError(__('messages.type_not_found', ['type' => __('main.why_us')]));
        $this->authorize('update', $whyUs);

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
        $updated = $whyUs->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $whyUs, 'image', 'why-us');
        }

        return $updated
            ? redirect()->route('dashboard.why-us.index')->withSuccess(__('messages.type_updated', ['type' => __('main.why_us')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.why_us')]));
    }
}