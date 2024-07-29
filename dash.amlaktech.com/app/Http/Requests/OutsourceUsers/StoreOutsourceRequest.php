<?php

namespace App\Http\Requests\OutsourceUsers;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutsourceRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|max:191',
            'email' => 'nullable|email|max:191',
            'phone_number' => 'nullable|numeric',
            'profession' => 'required|max:191',
            'salary' => 'required|numeric'
        ];
    }
}
