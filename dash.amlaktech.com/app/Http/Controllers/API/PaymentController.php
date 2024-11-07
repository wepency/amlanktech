<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use generateAPI;

    public function pay() {
        return $this->success([
            'payment_url' => (new PaymentService)->payInfo("111123", 100, 'https://amlacktech.com')
        ]);
    }
}
