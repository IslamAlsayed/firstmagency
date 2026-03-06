<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Models\Company;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class CompanyController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Company::class;

    public function index()
    {
        $this->authorize('viewAny', Company::class);
        $companies = Company::with(['creator'])->latest()->paginate(15);
        return view('dashboard.companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorize('create', Company::class);
        return view('dashboard.companies.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Company::class);
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
        $company = Company::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $company, 'image', 'companies');
        }

        return $company
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.company_created'))
                : redirect()->route('dashboard.companies.index')->withSuccess(__('messages.type_created', ['type' => __('main.company')])))
            : redirect()->route('dashboard.companies.index')->withError(__('messages.type_creation_failed', ['type' => __('main.company')]));
    }

    public function show($id)
    {
        $company = Company::find($id);
        if (!$company)
            return redirect()->route('dashboard.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.company')]));
        $this->authorize('view', $company);
        return view('dashboard.companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::find($id);
        if (!$company)
            return redirect()->route('dashboard.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.company')]));
        $this->authorize('update', $company);
        return view('dashboard.companies.edit', compact('company'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $company = Company::find($id);
        if (!$company)
            return redirect()->route('dashboard.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.company')]));
        $this->authorize('update', $company);

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
        $updated = $company->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $company, 'image', 'companies');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.company')]))
            : redirect()->route('dashboard.companies.index')->withError(__('messages.type_update_failed', ['type' => __('main.company')]));
    }

    public function changeStatus($id, $status)
    {
        $company = Company::find($id);
        if (!$company)
            return redirect()->route('dashboard.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.company')]));

        // Check if user can update companies
        $this->authorize('update', $company);

        // Validate status
        $validStatuses = ['published', 'draft'];
        if (!in_array($status, $validStatuses)) {
            return back()->withError(__('messages.invalid_status'));
        }

        $company->update([
            'status' => $status,
            'updated_by' => getActiveUserId(),
        ]);

        $statusLabel = __('main.' . $status);
        return redirect()->route('dashboard.companies.index')->withSuccess(
            __('messages.type_updated', ['type' => __('main.company')]) . ' - ' . $statusLabel
        );
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if (!$company)
            return redirect()->route('dashboard.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.company')]));

        $this->authorize('delete', $company);

        $company->delete();

        return redirect()->route('dashboard.companies.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.company')]));
    }
}
