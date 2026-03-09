<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialDomain\StoreRequest;
use App\Http\Requests\OfficialDomain\UpdateRequest;
use App\Models\OfficialDomain;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class OfficialDomainController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = OfficialDomain::class;

    public function index()
    {
        $this->authorize('viewAny', OfficialDomain::class);
        $officialDomains = OfficialDomain::with(['creator'])->latest()->paginate(15);
        return view('dashboard.official-domains.index', compact('officialDomains'));
    }

    public function create()
    {
        $this->authorize('create', OfficialDomain::class);
        return view('dashboard.official-domains.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', OfficialDomain::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'badge' => $request->input("badge_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $officialDomain = OfficialDomain::create($validated);

        return $officialDomain
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.official_domain')]))
                : redirect()->route('dashboard.official-domains.index')->withSuccess(__('messages.type_created', ['type' => __('main.official_domain')])))
            : redirect()->route('dashboard.official-domains.index')->withError(__('messages.type_creation_failed', ['type' => __('main.official_domain')]));
    }

    public function show($id)
    {
        $officialDomain = OfficialDomain::find($id);
        if (!$officialDomain)
            return redirect()->route('dashboard.official-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.official_domain')]));
        $this->authorize('view', $officialDomain);
        return view('dashboard.official-domains.show', compact('officialDomain'));
    }

    public function edit($id)
    {
        $officialDomain = OfficialDomain::find($id);
        if (!$officialDomain)
            return redirect()->route('dashboard.official-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.official_domain')]));
        $this->authorize('update', $officialDomain);
        return view('dashboard.official-domains.edit', compact('officialDomain'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $officialDomain = OfficialDomain::find($id);
        if (!$officialDomain)
            return redirect()->route('dashboard.official-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.official_domain')]));
        $this->authorize('update', $officialDomain);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'badge' => $request->input("badge_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $officialDomain->update($validated);

        return $updated
            ? redirect()->route('dashboard.official-domains.index')->withSuccess(__('messages.type_updated', ['type' => __('main.official_domain')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.official_domain')]));
    }
}
