<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
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

    public function store(\Illuminate\Http\Request $request)
    {
        $this->authorize('create', Permission::class);
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'guard_name' => 'required|string|in:web,api',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create($validated);

        return redirect()->route('dashboard.permissions.index')->withSuccess('Permission created successfully.');
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

    public function update(\Illuminate\Http\Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id . '|max:255',
            'guard_name' => 'required|string|in:web,api',
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update($validated);

        return redirect()->route('dashboard.permissions.index')->withSuccess('Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $permission->delete();
        return redirect()->route('dashboard.permissions.index')->withSuccess('Permission deleted successfully.');
    }
}
