<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class MemberRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|numeric|unique:members,phone_number',

            'association_id' => 'required|numeric',

            'ownership_type' => 'required|in:individual,group',

            'ownership_ratio' => [
                'nullable',
                'required_if:ownership_type,group',
                'numeric',
                'max:100',
            ],

            'fee_type_amount' => 'required|numeric',

            'address' => 'required|string',
            'water_meter_serial' => 'required',
            'electricity_meter_serial' => 'required',
            'area' => 'required'
        ];
    }
}
