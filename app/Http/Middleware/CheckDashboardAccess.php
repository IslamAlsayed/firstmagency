<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardAccess
{
    /**
     * التحقق من وصول المستخدم للـ Dashboard
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withError(__('messages.please_login_to_continue'));
        }

        if (!Auth::user()->canAccessDashboard()) {
            return redirect()->back()->withError('غير مصرح لك بالوصول للـ Dashboard.');
        }

        return $next($request);
    }
}
