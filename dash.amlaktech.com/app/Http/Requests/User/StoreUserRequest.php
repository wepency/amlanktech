<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|digits:10',
            'password' => 'required|confirmed|min:8',
            'salary'=>'nullable',
            'address'=>'nullable|string',
            'status'=>'nullable',
        ];
    }
}
