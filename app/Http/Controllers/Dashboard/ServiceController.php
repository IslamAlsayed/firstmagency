<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreRequest;
use App\Http\Requests\Service\UpdateRequest;
use App\Models\Service;
use App\Traits\PhotoUploadTrait;

class ServiceController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $this->authorize('viewAny', Service::class);
        $services = Service::with(['creator'])->latest()->paginate(15);
        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        $this->authorize('create', Service::class);
        return view('dashboard.services.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Service::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $request->input("keywords_{$lang}") ?? '',
                'meta_description' => $request->input("meta_description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $service = Service::create($validated);

        if ($request->hasFile('icon')) {
            $this->uploadSinglePhoto($request, $service, 'icon', 'services/icons');
        }
        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $service, 'image', 'services/images');
        }

        return $service
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.service_created'))
                : redirect()->route('dashboard.services.index')->withSuccess(__('messages.type_created', ['type' => __('main.service')])))
            : redirect()->route('dashboard.services.index')->withError(__('messages.type_creation_failed', ['type' => __('main.service')]));
    }

    public function show($id)
    {
        $service = Service::find($id);
        if (!$service)
            return redirect()->route('dashboard.services.index')->withError(__('messages.type_not_found', ['type' => __('main.service')]));
        $this->authorize('view', $service);
        return view('dashboard.services.show', compact('service'));
    }

    public function edit($id)
    {
        $service = Service::find($id);
        if (!$service)
            return redirect()->route('dashboard.services.index')->withError(__('messages.type_not_found', ['type' => __('main.service')]));
        $this->authorize('update', $service);
        return view('dashboard.services.edit', compact('service'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $service = Service::find($id);
        if (!$service)
            return redirect()->route('dashboard.services.index')->withError(__('messages.type_not_found', ['type' => __('main.service')]));
        $this->authorize('update', $service);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $request->input("keywords_{$lang}") ?? '',
                'meta_description' => $request->input("meta_description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $service->update($validated);

        if ($request->hasFile('icon')) {
            $this->uploadSinglePhoto($request, $service, 'icon', 'services/icons');
        }
        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $service, 'image', 'services/images');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.service')]))
            : redirect()->route('dashboard.services.index')->withError(__('messages.type_update_failed', ['type' => __('main.service')]));
    }

    public function changeStatus($id, $status)
    {
        $service = Service::find($id);
        if (!$service)
            return redirect()->route('dashboard.services.index')->withError(__('messages.type_not_found', ['type' => __('main.service')]));

        // Check if user can update services
        $this->authorize('update', $service);

        // Validate status
        $validStatuses = ['active', 'inactive'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('dashboard.services.index')->withError('Invalid status');
        }

        $service->update([
            'status' => $status,
            'updated_by' => getActiveUserId(),
        ]);

        $statusLabel = __('main.status_' . $status);
        return redirect()->route('dashboard.services.index')->withSuccess(
            __('messages.type_updated', ['type' => __('main.service')]) . ' - ' . $statusLabel
        );
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service)
            return redirect()->route('dashboard.services.index')->withError(__('messages.type_not_found', ['type' => __('main.service')]));

        $this->authorize('delete', $service);

        $service->delete();

        return redirect()->route('dashboard.services.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.service')]));
    }
}