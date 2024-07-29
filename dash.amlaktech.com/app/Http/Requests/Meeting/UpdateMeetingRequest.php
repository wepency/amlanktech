<?php

namespace App\Http\Requests\Meeting;

use App\Models\Meeting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'association_id' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'meeting_id' => 'required',
            'passcode' => 'required',
        ];


    }
}
