<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Modules\Core\Http\Requests\User\StoreRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('dashboard.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('user');

        event(new Registered($user));
        activity()->causedBy($user)->performedOn($user)->useLog('models')->event('register')->withProperties([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'registration_time' => now()->toDateTimeString(),
        ])->log('New user registered');
        Auth::login($user);
        return redirect(route('dashboard', false))->withSuccess(__('messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
    }
}