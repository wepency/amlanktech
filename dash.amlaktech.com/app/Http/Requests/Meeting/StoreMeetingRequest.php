<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'association_id' => 'nullable|numeric',
            'meeting_id' => 'required',
            'passcode' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'nullable',
        ];
    }
}
