<?php

namespace App\Traits;

use App\Http\Resources\API\AssociationsResource;
use Illuminate\Support\Str;

trait Token
{
    protected function respondWithToken($token)
    {
        $user = get_auth()->user();

        return [
            'access_token' => $token,

            "user" => [
                "id" => $user?->id,
                "status" => is_null(get_auth()->user()->status) ? "pending" : "approved",
                "name" => $user?->name,
                "email" => $user?->email,
                "phonenumber" => $user?->phonenumber,
                "avatar" => get_user_avatar(Str::slug($user->name))
            ],

            "associations" => AssociationsResource::collection($user->memberAssociations),

            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration'),

            'statics' => [
                'associations' => $user->memberAssociations()->count(),
                'units' => get_auth()->user()->units()->count(),
                'tickets' => get_auth()->user()->tickets()->count(),
                'subscriptions' => 2,
                'awaiting_subscriptions' => 1
            ]
        ];
    }

    protected function respondAdminWithToken($token)
    {
//        return [
//            'access_token' => $token,
//            'user' => auth('api_admin')->user(),
//            'token_type' => 'bearer',
//            'expires_in' => JWTAuth::factory()->getTTl()
//        ];

        $user = get_auth()->user();

        return [
            'access_token' => $token,

            'user' => [
                "id" => $user?->id,
                "name" => $user?->name,
                "email" => $user?->email,
                "phonenumber" => $user?->phonenumber,
                "is_verified" => !is_null($user->phone_verified_at),
                "points" => $user?->points,
                "avatar" => get_user_avatar(Str::slug($user->name))
            ],

            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration')
        ];
    }
}
