<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Admin $admin = null): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
//            'national_id' => 'required|numeric|unique:admins,national_id,' . $admin->id,
            'phone_number' => 'required|unique:admins,phone_number,' . $admin->id,
            'password' => 'nullable|confirmed|min:8',
        ];
    }
}
