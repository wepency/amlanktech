<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssociationMember
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('member')->check()) {
            if (auth('member')->user()->status == 1)
                return $next($request);
            else
                return redirect('/waiting-approval');
        }

        return redirect()->to(url('/login'));
    }
}
