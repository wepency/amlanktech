<?php

namespace App\Http\Requests\PaymentReceipt;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentReceiptRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'unit_id' => 'nullable',
            'association_member_id' => 'nullable',
            'image' => 'nullable',
            'type' => 'nullable',
            'from_date' => 'nullable',
            'to_date' => 'nullable',
            'status' => 'nullable',
            'value' => 'required',
        ];
    }
}
