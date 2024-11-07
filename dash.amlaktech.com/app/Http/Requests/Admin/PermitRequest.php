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
            'permit_days' => 'required|numeric|max:365',
            'type' => 'required|in:maintenance,worker,deliver,visitor',
            'visitors' => 'required|array'
        ];
    }

    public function attributes()
    {
        return [
            'association_id' => 'المعرف الخاص بالجمعية',
            'member_id' => 'المعرف الخاص بالمالك',
            'login_attempts' => 'مرات الدخول',
            'start_date' => 'تاريخ الدخول',
            'permit_days' => 'عدد ايام التصريح',
            'type' => 'نوع التصريح',
            'visitors' => 'الزوار'
        ];
    }
}
