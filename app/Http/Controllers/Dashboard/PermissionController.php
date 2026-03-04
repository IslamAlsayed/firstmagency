<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\GlobalDestroyTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use GlobalDestroyTrait;

    protected $modelClass = Permission::class;

    public function index()
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = Permission::all();
        return view('dashboard.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->authorize('create', Permission::class);
        return view('dashboard.permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        Permission::create($validated);
        return redirect()->route('dashboard.permissions.index')->withSuccess(__('messages.permission_created_successfully'));
    }

    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);
        return view('dashboard.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);
        return view('dashboard.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id . '|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        $permission->update($validated);
        return redirect()->route('dashboard.permissions.index')->withSuccess(__('messages.permission_updated_successfully'));
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $permission->delete();
        return redirect()->route('dashboard.permissions.index')->withSuccess(__('messages.permission_deleted_successfully'));
    }
}
