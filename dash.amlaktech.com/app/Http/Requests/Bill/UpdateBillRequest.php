<?php

namespace App\Http\Requests\Bill;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBillRequest extends FormRequest
{

   
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'value' => 'required',
            'date' => 'nullable',

        ];

     
    }
}
