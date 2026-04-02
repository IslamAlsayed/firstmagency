<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsAdminApi
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();

        if (! $user || ! $user->canAccessDashboard() && $user->role !== 'support') {
            return response()->json([
                'success' => false,
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        return $next($request);
    }
}
