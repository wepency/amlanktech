<?php

namespace App\Http\Actions\Bill;

use App\Models\Bill;
use Illuminate\Http\Request;

class UpdateBillHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Bill $bill,
    )
    {
    }

    public function handle(): self
    {
        if (is_manager()) {
            $this->bill->association_id = auth()->user()->association_id;
        }else {
            $this->bill->association_id = $this->request->get('association_id');
        }

        $this->bill->name= $this->request->get('name');
        $this->bill->value = $this->request->get('value');
        $this->bill->date = $this->request->get('date');

        $this->bill->repeated = $this->request->get('repeated') == 'on';
        $this->bill->notes = $this->request->get('notes');

        $this->bill->save();

        $this->message = 'The User Has Been Updated Successfully';

        return $this;
    }

}
