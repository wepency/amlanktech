<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\SubscriptionsResource;
use App\Models\Subscription;
use App\Traits\generateAPI;

class SubscriptionsController extends Controller
{
    use generateAPI;

    public function index()
    {
        return $this->success(['subscriptions' => SubscriptionsResource::collection(get_auth()->user()->subscriptions)]);
    }

    public function show(Subscription $subscription)
    {
        return $this->success(['subscriptions' => SubscriptionsResource::make($subscription)]);
    }
}
