<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = Role::all();
        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create', Role::class);
        $permissions = Permission::all();
        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        // Get and filter permissions BEFORE validation
        $permissionsInput = (array) $request->input('permissions', []);
        $filteredPermissions = array_values(array_filter($permissionsInput, function ($val) {
            return $val !== '0' && $val !== 0 && $val !== '';
        }));

        // Merge filtered permissions back into request for validation
        $request->merge(['permissions' => $filteredPermissions]);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('dashboard.roles.index')->withSuccess('Role created successfully.');
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);
        $role->load('permissions');
        return view('dashboard.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(\Illuminate\Http\Request $request, Role $role)
    {
        $this->authorize('update', $role);

        // Get and filter permissions BEFORE validation
        $permissionsInput = (array) $request->input('permissions', []);
        $filteredPermissions = array_values(array_filter($permissionsInput, function ($val) {
            return $val !== '0' && $val !== 0 && $val !== '';
        }));

        // Merge filtered permissions back into request for validation
        $request->merge(['permissions' => $filteredPermissions]);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id . '|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Update only the name (permissions is not a direct model attribute)
        $role->update(['name' => $validated['name']]);

        // Handle permission synchronization separately
        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('dashboard.roles.index')->withSuccess('Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->route('dashboard.roles.index')->withSuccess('Role deleted successfully.');
    }
}
