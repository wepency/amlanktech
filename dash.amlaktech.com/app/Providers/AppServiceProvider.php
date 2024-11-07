<?php

namespace App\Providers;

use App\Services\BudgetService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Relation::morphMap([
            'web' => \App\Models\User::class,
            'member' => \App\Models\AssociationMember::class,
            'admin' => \App\Models\Admin::class,
            'manager' => \App\Models\Admin::class,
        ]);

        include_once app_path('Helpers/Helpers.php');
        include_once app_path('Helpers/Constants.php');

        Paginator::useBootstrapFive();
    }
}
