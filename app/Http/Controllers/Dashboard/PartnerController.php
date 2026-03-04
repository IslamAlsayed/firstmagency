<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\StoreRequest;
use App\Http\Requests\Partner\UpdateRequest;
use App\Models\Partner;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class PartnerController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Partner::class;

    public function index()
    {
        $this->authorize('viewAny', Partner::class);
        $partners = Partner::with(['creator'])->latest()->paginate(15);
        return view('dashboard.partners.index', compact('partners'));
    }

    public function create()
    {
        $this->authorize('create', Partner::class);
        return view('dashboard.partners.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Partner::class);
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
        $partner = Partner::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $partner, 'image', 'partners');
        }

        return $partner
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.partner')]))
                : redirect()->route('dashboard.partners.index')->withSuccess(__('messages.type_created', ['type' => __('main.partner')])))
            : redirect()->route('dashboard.partners.index')->withError(__('messages.type_creation_failed', ['type' => __('main.partner')]));
    }

    public function show($id)
    {
        $partner = Partner::find($id);
        if (!$partner)
            return redirect()->route('dashboard.partners.index')->withError(__('messages.type_not_found', ['type' => __('main.partner')]));
        $this->authorize('view', $partner);
        return view('dashboard.partners.show', compact('partner'));
    }

    public function edit($id)
    {
        $partner = Partner::find($id);
        if (!$partner)
            return redirect()->route('dashboard.partners.index')->withError(__('messages.type_not_found', ['type' => __('main.partner')]));
        $this->authorize('update', $partner);
        return view('dashboard.partners.edit', compact('partner'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $partner = Partner::find($id);
        if (!$partner)
            return redirect()->route('dashboard.partners.index')->withError(__('messages.type_not_found', ['type' => __('main.partner')]));
        $this->authorize('update', $partner);

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
        $updated = $partner->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $partner, 'image', 'partners');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.partner')]))
            : redirect()->route('dashboard.partners.index')->withError(__('messages.type_update_failed', ['type' => __('main.partner')]));
    }

    public function changeStatus($id, $status)
    {
        $partner = Partner::find($id);
        if (!$partner)
            return redirect()->route('dashboard.partners.index')->withError(__('messages.type_not_found', ['type' => __('main.partner')]));

        // Check if user can update partners
        $this->authorize('update', $partner);

        // Validate status
        $validStatuses = ['published', 'draft'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('dashboard.partners.index')->withError('Invalid status');
        }

        $partner->update([
            'status' => $status,
            'updated_by' => getActiveUserId(),
        ]);

        $statusLabel = __('main.status_' . $status);
        return redirect()->route('dashboard.partners.index')->withSuccess(__('messages.type_updated', ['type' => __('main.partner')]) . ' - ' . $statusLabel);
    }
}
