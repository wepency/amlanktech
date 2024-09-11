<?php

namespace App\Http\Controllers\API;

use App\Classes\PhoneNumber;
use App\Http\Controllers\Controller;
use App\Traits\generateAPI;
use App\Traits\Token;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use generateAPI, Token;

    public function __invoke(Request $request)
    {

        $username = $request->get('username');
        $user = false;

        if (is_numeric($username)) {
            $username = PhoneNumber::validatePhoneNumber($username)['number'];
            $user = auth('web')->attempt(['phone_number' => $username, 'password' => $request->password]);
        } else if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = auth('web')->attempt(['email' => $username, 'password' => $request->password]);
        }

        if ($user) {
            $status = auth('sanctum')->user()->status;

            if ($status != 1) {
                $message = match ($status) {
                    2 => 'هذا الحساب معلق، برجاء التواصل مع الدعم الفني.',
                    default => 'الحساب بانتظار المراجعة، برجاء الانتظار.'
                };

                return $this->error([$message]);
            }

            $token = get_auth()->user()->createToken('user')->plainTextToken;
            return $this->success([$this->respondWithToken($token)]);
        }

        return $this->error(['برجاء التأكد من البيانات المرسلة.'], null, 401);
    }
}
