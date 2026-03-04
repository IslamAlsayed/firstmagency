<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUs\StoreRequest;
use App\Http\Requests\AboutUs\UpdateRequest;
use App\Models\AboutUs;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class AboutUsController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = AboutUs::class;

    public function index()
    {
        $this->authorize('viewAny', AboutUs::class);
        $aboutUs = AboutUs::with(['creator'])->latest()->paginate(15);
        return view('dashboard.about-us.index', compact('aboutUs'));
    }

    public function create()
    {
        $this->authorize('create', AboutUs::class);
        return view('dashboard.about-us.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', AboutUs::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        $aboutUs = AboutUs::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $aboutUs, 'image', 'about-us');
        }

        return $aboutUs
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.about_us')]))
                : redirect()->route('dashboard.about-us.index')->withSuccess(__('messages.type_created', ['type' => __('main.about_us')])))
            : redirect()->route('dashboard.about-us.index')->withError(__('messages.type_creation_failed', ['type' => __('main.about_us')]));
    }

    public function show($id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs)
            return redirect()->route('dashboard.about-us.index')->withError(__('messages.type_not_found', ['type' => __('main.about_us')]));
        $this->authorize('view', $aboutUs);
        return view('dashboard.about-us.show', compact('aboutUs'));
    }

    public function edit($id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs)
            return redirect()->route('dashboard.about-us.index')->withError(__('messages.type_not_found', ['type' => __('main.about_us')]));
        $this->authorize('update', $aboutUs);
        return view('dashboard.about-us.edit', compact('aboutUs'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs)
            return redirect()->route('dashboard.about-us.index')->withError(__('messages.type_not_found', ['type' => __('main.about_us')]));
        $this->authorize('update', $aboutUs);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        $updated = $aboutUs->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $aboutUs, 'image', 'about-us');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.about_us')]))
            : redirect()->route('dashboard.about-us.index')->withError(__('messages.type_update_failed', ['type' => __('main.about_us')]));
    }
}
