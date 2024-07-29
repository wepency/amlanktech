<?php

namespace App\Http\Middleware;

use App\Traits\generateAPI;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidatedUser
{
    use generateAPI;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (get_auth()->check() && get_auth()->user()->status == 1)
            return $next($request);

        if ($request->json()) {
            Log::debug("This is not validated user.");
            return $this->error(['برجاء التأكد من ان حسابك فعال.']);
        }

        abort(401);
    }
}
