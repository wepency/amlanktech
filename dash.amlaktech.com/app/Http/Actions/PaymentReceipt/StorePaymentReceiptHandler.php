<?php

namespace App\Http\Actions\PaymentReceipt;

use App\Models\PaymentReceipt;
use App\Models\User;
use Illuminate\Http\Request;

class StorePaymentReceiptHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): PaymentReceipt
    {
        $receipt = new PaymentReceipt();


        $member_id = $this->request->get('association_member_id');

        $association_id = User::findOrFail($member_id)->association->id;

        $receipt->title= $this->request->get('title');
        $receipt->status = $this->request->get('status');
        $receipt->type = $this->request->get('type');
        $receipt->unit_id = $this->request->get('unit_id');
        $receipt->association_member_id = $member_id;
        $receipt->association_id = $association_id;
        $receipt->from_date = $this->request->get('from_date');
        $receipt->to_date = $this->request->get('to_date');
        $receipt->value = $this->request->get('value');

        // dd($this->request->file('image'));
        if ($this->request->file('image')) {
            $file = $this->request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/receipts'), $fileName);

            $imagePath = 'storage/receipts/' . $fileName;

        }

        $receipt->image = $imagePath;


        $receipt->save();

        return $receipt;
    }
}
