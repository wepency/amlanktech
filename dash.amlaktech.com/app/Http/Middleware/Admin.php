<?php

namespace App\Http\Middleware;

use App\Services\BudgetService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check()) {

            if (!is_admin()) {
                BudgetService::updateCache(getAssociationId());
            }

            return $next($request);
        }

        return redirect()->route('dashboard.login');
    }
}
