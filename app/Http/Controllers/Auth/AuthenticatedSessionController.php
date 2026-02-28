<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        if (session('login_attempted')) {
            return view('dashboard.auth.login');
        }

        // Only show 'please_login_to_continue' on first visit, not every time
        if (!session('login_attempted')) {
            session(['login_attempted' => true]);
            showToastInfoMessage(__('messages.please_login_to_continue'));
        }
        return view('dashboard.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = getActiveUser();
        // if ($user) { }
        showToastSuccessMessage(__('messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect()->intended(route('dashboard.index', false));
    }

    /**
     * Destroy an authenticated session.
     */
    public static function destroy(Request $request)
    {
        $user = getActiveUser();
        // if ($user) { }
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        showToastSuccessMessage(__('messages.goodbye_name', ['name' => $user->name ?? 'User']));
        return redirect('/');
    }
}
