<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerRequest extends FormRequest
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
    public function rules(Admin $manager): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $manager->id,
            'national_id' => 'required|numeric|unique:admins,national_id,' . $manager->id,
            'phone_number' => 'required|unique:admins,phone_number,' . $manager->id,
            'association_id' => 'nullable|numeric',
            'password' => 'nullable|confirmed|min:8',
        ];
    }
}
