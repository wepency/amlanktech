<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const NAMESPACE = 'App\\Http\\Controllers';
    public const ADMIN_NAMESPACE = 'App\\Http\\Controllers\\Admin';
    public const MEMBER_NAMESPACE = 'App\\Http\\Controllers\\Member';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            // Admin Route File
//            Route::middleware('web')
//                ->as('dashboard.')
//                ->namespace(self::ADMIN_NAMESPACE)
//                ->prefix('dashboard')
//                ->group(base_path('routes/admin.php'));

            // Admin Route File
//            Route::middleware('web')
//                ->as('member.')
//                ->namespace(self::MEMBER_NAMESPACE)
//                ->prefix('member')
//                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->namespace(self::ADMIN_NAMESPACE)
                ->prefix('dashboard')
                ->as('dashboard.')
                ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(1000)->by($request->user()?->id ?: $request->ip());
        });
    }
}
