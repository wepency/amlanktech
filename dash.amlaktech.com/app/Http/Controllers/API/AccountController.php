<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\generateAPI;
use App\Traits\Token;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use generateAPI, Token;

    public function me(Request $request)
    {
        return $this->success($this->respondWithToken($request->bearerToken()));
    }
}
