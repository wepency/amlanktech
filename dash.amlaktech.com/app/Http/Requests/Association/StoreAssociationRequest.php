<?php

namespace App\Http\Requests\Association;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssociationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'map_link' => 'required|string',
            'registration_number' => 'required|numeric',
            'fee_type_id' => 'required|numeric',
            'fee_amount' => 'required|numeric',
            'admin_id' => 'nullable|integer',
            'registration_certificate' => 'nullable|file|mimes:pdf,docx,png,jpg,jpeg,svg,gif,xlsx|max:4096',
        ];
    }
}
