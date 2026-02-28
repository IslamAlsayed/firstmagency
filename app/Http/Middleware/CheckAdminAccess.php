<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    /**
     * التحقق من وصول المستخدم كـ Admin أو Super Admin
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withError(__('messages.please_login_to_continue'));
        }

        if (!Auth::user()->canManageSettings()) {
            return redirect()->back()->withError('هذا الخيار متاح فقط للمسؤولين.');
        }

        return $next($request);
    }
}