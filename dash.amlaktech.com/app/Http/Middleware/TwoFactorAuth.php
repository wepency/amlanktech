<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('2fa')) {
            return $next($request);
        }

        if (auth('admin')->check()) {
            redirect(dashboard_route('login'));
        }

        return redirect(dashboard_route('login.otp'));
    }
}
