<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = User::class;

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::query()->latest()->paginate(25);
        $roles = Role::pluck('name')->toArray();
        $roleStats = User::query()->selectRaw('role, COUNT(*) as total')->groupBy('role')->pluck('total', 'role');

        $allItems = User::count();
        $superAdmins = (int) ($roleStats['superadmin'] ?? 0);
        $admins = (int) ($roleStats['admin'] ?? 0);
        $contentManagers = (int) ($roleStats['content_manager'] ?? 0);
        return view('dashboard.users.index', compact('users', 'allItems', 'superAdmins', 'admins', 'contentManagers', 'roles'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('dashboard.users.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', User::class);
        $user = User::create($request->validated());

        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $user, 'photo', 'users');
        }
        return redirect()->route('dashboard.users.index')->withSuccess(__('messages.user_created'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect()->route('dashboard.users.index')->withError(__('messages.type_not_found', ['type' => __('main.user')]));
        $this->authorize('update', $user);

        $user->update($request->validated());

        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $user, 'photo', 'users');
        }
        return redirect()->route('dashboard.users.index')->withSuccess(__('messages.user_updated'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('dashboard.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        return $this->destroyModel($user, 'users');
    }

    /**
     * Switch to a different account (Development Only)
     */
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);

        // Log out current user
        Auth::logout();

        // Log in as the new user
        Auth::login($user, remember: true);

        return redirect()->back()->withSuccess(__('messages.switched_to_user', ['name' => $user->name]));

        // if (in_array($user->role, ['superadmin', 'admin'])) {
        //     return redirect()->back()->withSuccess(__('messages.switched_to_user', ['name' => $user->name]));
        // }
        // return redirect()->route('dashboard.index')->withSuccess(__('messages.switched_to_user', ['name' => $user->name]));
    }

    /**
     * Show the current user's permissions (direct and via roles).
     */
    public function myPermissions()
    {
        $user = getActiveUser();
        $allPermissions = $user->getAllPermissions();
        $directPermissions = $user->permissions;
        $rolePermissions = $allPermissions->diff($directPermissions);
        $roles = $user->roles;
        return view('dashboard.users.my-permissions', compact('user', 'allPermissions', 'directPermissions', 'rolePermissions', 'roles'));
    }

    /**
     * Show the form for editing a user's direct permissions.
     */
    public function editPermissions(User $user)
    {
        $this->authorize('update', $user);
        $permissions = Permission::all();
        return view('dashboard.users.permissions', compact('user', 'permissions'));
    }

    /**
     * Update a user's direct permissions.
     */
    public function updatePermissions(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $permissions = $request->input('permissions', []);
        $permissions = array_filter($permissions); // remove zeros
        $user->syncPermissions($permissions);
        return redirect()->route('dashboard.users.editPermissions', $user->id)->withSuccess(__('messages.permissions_updated'));
    }
}
