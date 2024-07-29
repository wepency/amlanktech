<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'association_id' => 'nullable|numeric',
            'member_id' => 'required|numeric',
            'login_attempts' => 'required|numeric',
            'start_date' => 'required',
            'permit_days' => 'required|numeric',
            'type' => 'required|in:maintenance,worker,deliver,visitor',
            'visitors' => 'required|array',
        ];
    }
}
