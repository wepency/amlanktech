<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{



    public function authorize(): bool
    {
        return true;
    }


    public function rules(User $user): array
    {
        return [
            'name'          => 'required',
            'phone_number'  => 'required|digits:10',
            'salary'        =>'nullable',
            'address'       =>'nullable',
            'city_id'       =>'nullable',
            'password'      => 'nullable|confirmed|min:8',

        ];

        if ($this->input('email') !== $user->email) {

            $rules['email'] = 'required|email|unique:users,email';
        } else {

            $rules['email'] = 'required|email';
        }

        if ($this->filled('password_confirmation')) {
            $rules['password'] = 'required|confirmed|min:8';
        }

    }
}
