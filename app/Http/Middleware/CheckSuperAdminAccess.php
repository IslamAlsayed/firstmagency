<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdminAccess
{
    /**
     * التحقق من وصول المستخدم كـ Super Admin
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // if (!Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin()) {
        if (!Auth::user()->isSuperAdmin()) {
            return redirect()->back()->withError('ليس لديك صلاحية الوصول إلى هذا القسم. هذا الخيار متاح فقط للمسؤول الأعلى.');
        }

        return $next($request);
    }
}
