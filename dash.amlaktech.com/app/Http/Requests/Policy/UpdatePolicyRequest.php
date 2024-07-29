<?php

namespace App\Http\Requests\Policy;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePolicyRequest extends FormRequest
{

   
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'association_id' => 'required|integer',
            'policy_file' => 'nullable|file|mimes:pdf|max:12288',

        ];

     
    }
}
