<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ClientController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Client::class;

    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::with(['creator'])->latest()->paginate(15);
        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        $this->authorize('create', Client::class);
        return view('dashboard.clients.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Client::class);
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
        $client = Client::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $client, 'image', 'clients');
        }

        return $client
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.client_created'))
                : redirect()->route('dashboard.clients.index')->withSuccess(__('messages.type_created', ['type' => __('main.client')])))
            : redirect()->route('dashboard.clients.index')->withError(__('messages.type_creation_failed', ['type' => __('main.client')]));
    }

    public function show($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->route('dashboard.clients.index')->withError(__('messages.type_not_found', ['type' => __('main.client')]));
        $this->authorize('view', $client);
        return view('dashboard.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->route('dashboard.clients.index')->withError(__('messages.type_not_found', ['type' => __('main.client')]));
        $this->authorize('update', $client);
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->route('dashboard.clients.index')->withError(__('messages.type_not_found', ['type' => __('main.client')]));
        $this->authorize('update', $client);

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
        $updated = $client->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $client, 'image', 'clients');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.client')]))
            : redirect()->route('dashboard.clients.index')->withError(__('messages.type_update_failed', ['type' => __('main.client')]));
    }

    public function changeStatus($id, $status)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->route('dashboard.clients.index')->withError(__('messages.type_not_found', ['type' => __('main.client')]));

        // Check if user can update clients
        $this->authorize('update', $client);

        // Validate status
        $validStatuses = ['published', 'draft'];
        if (!in_array($status, $validStatuses)) {
            return back()->withError(__('messages.invalid_status'));
        }

        $client->update([
            'status' => $status,
            'updated_by' => getActiveUserId(),
        ]);

        $statusLabel = __('main.' . $status);
        return redirect()->route('dashboard.clients.index')->withSuccess(
            __('messages.type_updated', ['type' => __('main.client')]) . ' - ' . $statusLabel
        );
    }
}
