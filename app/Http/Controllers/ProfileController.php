<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePhotoRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use PhotoUploadTrait;

    public function show()
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));

        if ($user->hasRole('superadmin')) {
            $users = User::all();
        } elseif ($user->hasRole('admin')) {
            $users = User::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'superadmin');
            })->get();
        } else {
            $users = collect([$user]);
        }
        return view('profile.show', compact('user', 'users'));
    }

    public function edit()
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        $validated = $request->validated();
        $user->update($validated);

        // Update session locales if changed
        if (isset($validated['website_locale'])) {
            session(['website_locale' => $validated['website_locale']]);
        }
        if (isset($validated['dashboard_locale'])) {
            session(['dashboard_locale' => $validated['dashboard_locale']]);
        }

        return redirect()->route('dashboard.profile.show')->withSuccess(__('main.profile_updated_successfully'));
    }

    public function updatePhoto(UpdatePhotoRequest $request)
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $user, 'photo', 'users');
        }
        return back()->withSuccess(__('main.photo_uploaded_successfully'));
    }

    public function deletePhoto()
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        if ($user->photo) {
            // Delete the photo file
            $photoPath = public_path('assets/images/avatars/' . $user->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            // Update the user record
            $user->update(['photo' => null]);
        }

        return back()->withSuccess(__('main.photo_deleted_successfully'));
    }

    public function changePassword(Request $request)
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => __('main.current_password_incorrect'),
            'password.min' => __('main.password_min_8'),
            'password.confirmed' => __('main.passwords_not_match'),
        ]);

        $user->update([
            'password' => $validated['password'],
            'password_changed_at' => now(),
        ]);

        return back()->withSuccess(__('main.password_changed_successfully'));
    }

    public function activity()
    {
        $user = getActiveUser();
        if (!$user)
            return redirect()->route('dashboard.index')->withErrors(__('messages.type_not_found', ['type' => __('main.user')]));
        $lastLogin = $user->last_login_at?->format('Y-m-d H:i:s') ?? __('main.never');
        $joinDate = $user->created_at->format('Y-m-d H:i:s');
        return view('profile.activity', compact('user', 'lastLogin', 'joinDate'));
    }
}
