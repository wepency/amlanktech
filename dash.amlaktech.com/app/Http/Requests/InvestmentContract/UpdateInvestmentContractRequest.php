<?php

namespace App\Http\Requests\InvestmentContract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvestmentContractRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'investment_type' => 'required|string|max:100',
            'amount' => 'required',
            'company_id' => 'required',
            'contract_file' => 'nullable|file|max:4096', 
        ];

    }
}