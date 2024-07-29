<?php

namespace App\Http\Rwquests\ServiceContract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceContractRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'service_type' => 'required|string|max:100',
            'amount' => 'required',
            'company_id' => 'required',
            'contract_file' => 'nullable|file|max:4096', 
        ];

    }
}