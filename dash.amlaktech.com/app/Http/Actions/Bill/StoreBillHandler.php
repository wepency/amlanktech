<?php

namespace App\Http\Actions\Bill;

use App\Models\Bill;
use Illuminate\Http\Request;

class StoreBillHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Bill
    {
        $bill = new Bill;

        if (is_manager()) {
            $bill->association_id = auth()->user()->association_id;
        }else {
            $bill->association_id = $this->request->get('association_id');
        }

        $bill->name= $this->request->get('name');
        $bill->value = $this->request->get('value');
        $bill->date = $this->request->get('date');

        $bill->repeated = $this->request->get('repeated') == 'on';
        $bill->notes = $this->request->get('notes');


        $bill->save();

        return $bill;
    }
}
