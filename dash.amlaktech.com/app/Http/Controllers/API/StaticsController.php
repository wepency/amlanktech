<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\generateAPI;

class StaticsController extends Controller
{
    use generateAPI;

    public function __invoke()
    {
        $user = User::findOrFail(get_auth()->id());

        $associations = (clone $user)->associations()->count();
        $units = (clone $user)->units()->count();

        $subscriptionsToPay = (clone $user)->subscriptions()->where('is_paid', '!=', 1)->count();

        $tickets = (clone $user)->tickets()->count();

        $subscriptions = (clone $user)->subscriptions()->count();

        return $this->success([
            'associations' => $associations,
            'units' => $units,
            'subscriptionsToPay' => $subscriptionsToPay,
            'tickets' => $tickets,
            'subscriptions' => $subscriptions,
        ]);
    }
}
