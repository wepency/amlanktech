<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'association_id' => 'required|numeric',
            'importance' => 'required|numeric',
            'body' => 'required',
            'status' => 'nullable',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,gif',
        ];
    }
}
