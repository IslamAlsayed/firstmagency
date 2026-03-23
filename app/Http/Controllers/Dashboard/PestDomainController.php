<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PestDomain\StoreRequest;
use App\Http\Requests\PestDomain\UpdateRequest;
use App\Models\PestDomain;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class PestDomainController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = PestDomain::class;

    public function index()
    {
        $this->authorize('viewAny', PestDomain::class);
        $pestDomains = PestDomain::with(['creator'])->latest()->paginate(15);
        return view('dashboard.pest-domains.index', compact('pestDomains'));
    }

    public function create()
    {
        $this->authorize('create', PestDomain::class);
        return view('dashboard.pest-domains.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', PestDomain::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        $pestDomain = PestDomain::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $pestDomain, 'image', 'pest-domains');
        }

        return $pestDomain
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.pest_domain')]))
                : redirect()->route('dashboard.pest-domains.index')->withSuccess(__('messages.type_created', ['type' => __('main.pest_domain')])))
            : redirect()->route('dashboard.pest-domains.index')->withError(__('messages.type_creation_failed', ['type' => __('main.pest_domain')]));
    }

    public function show($id)
    {
        $pestDomain = PestDomain::find($id);
        if (!$pestDomain)
            return redirect()->route('dashboard.pest-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.pest_domain')]));
        $this->authorize('view', $pestDomain);
        return view('dashboard.pest-domains.show', compact('pestDomain'));
    }

    public function edit($id)
    {
        $pestDomain = PestDomain::find($id);
        if (!$pestDomain)
            return redirect()->route('dashboard.pest-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.pest_domain')]));
        $this->authorize('update', $pestDomain);
        return view('dashboard.pest-domains.edit', compact('pestDomain'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $pestDomain = PestDomain::find($id);
        if (!$pestDomain)
            return redirect()->route('dashboard.pest-domains.index')->withError(__('messages.type_not_found', ['type' => __('main.pest_domain')]));
        $this->authorize('update', $pestDomain);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();
        $updated = $pestDomain->update($validated);

        if ($request->hasFile('remove_image')  && $request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $pestDomain, 'image', 'pest-domains');
        }

        return $updated
            ? redirect()->route('dashboard.pest-domains.index')->withSuccess(__('messages.type_updated', ['type' => __('main.pest_domain')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.pest_domain')]));
    }

    public function destroy(PestDomain $pestDomain)
    {
        return $this->destroyModel($pestDomain, 'pest-domains');
    }
}
