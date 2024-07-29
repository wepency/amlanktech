<?php

namespace App\Http\Actions\PaymentReceipt;

use App\Models\AssociationMember;
use App\Models\PaymentReceipt;
use Illuminate\Http\Request;

class UpdatePaymentReceiptHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public PaymentReceipt $receipt,
    )
    {
    }

    public function handle(): self
    {
    
        $member_id = $this->request->get('association_member_id');

        $association_id = AssociationMember::findOrFail($member_id)->association->id;

        $this->receipt->title= $this->request->get('title');
        $this->receipt->status = $this->request->get('status');
        $this->receipt->type = $this->request->get('type');
        $this->receipt->unit_id = $this->request->get('unit_id');
        $this->receipt->association_member_id = $member_id;
        $this->receipt->association_id = $association_id;
        $this->receipt->from_date = $this->request->get('from_date');
        $this->receipt->to_date = $this->request->get('to_date');
        $this->receipt->value = $this->request->get('value');

        if ($this->request->file('image')) {
            $file = $this->request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/receipts'), $fileName);
    
            $imagePath = 'storage/receipts/' . $fileName;
    
            $data['image'] = $imagePath;
        }

        $this->receipt->save();

        $this->message = 'The Payment Receipt Has Been Updated Successfully';

        return $this;
    }

}
