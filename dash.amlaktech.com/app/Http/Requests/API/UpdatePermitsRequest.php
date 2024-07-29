<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermitsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'association_id' => 'required|numeric',
            'login_attempts' => 'required|numeric',
            'start_date' => 'required',
            'permit_days' => 'required|numeric',
            'type' => 'required|in:maintenance,worker,deliver,visitor',
            'visitors' => 'required',
        ];
    }
}
