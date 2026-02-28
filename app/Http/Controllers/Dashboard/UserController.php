<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::all();
        return view('dashboard.users.index', compact('users'));
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
        return redirect()->route('dashboard.users.index')->withSuccess('User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $user, 'photo', 'users');
        }
        return redirect()->route('dashboard.users.index')->withSuccess('User updated successfully.');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('dashboard.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('dashboard.users.index')->withSuccess('User deleted successfully.');
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

        return redirect()->route('dashboard')->with('success', __('messages.switched_to_user', ['name' => $user->name]));
    }
}
