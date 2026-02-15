<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale exists in session
        if (session()->has('locale') && in_array(session('locale'), ['en', 'ar'])) {
            app()->setLocale(session('locale'));
        } else {
            // Default locale is Arabic
            app()->setLocale('ar');
        }

        return $next($request);
    }
}
