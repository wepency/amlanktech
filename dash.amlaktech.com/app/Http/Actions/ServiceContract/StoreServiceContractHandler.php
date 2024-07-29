<?php

namespace App\Http\Actions\ServiceContract;

use App\Models\ServiceCompanyContract;
use Illuminate\Http\Request;

class StoreServiceContractHandler
{

    public function __construct(
        public Request $request
    ){}

    public function handle(): ServiceCompanyContract
    {
        
        $serviceContract = new ServiceCompanyContract();
        $serviceContract->service_type= $this->request->get('service_type');
        $serviceContract->amount = $this->request->get('amount');
        $serviceContract->company_id = $this->request->get('company_id');

        if ($this->request->hasFile('contract_file')) {
            $file = $this->request->file('contract_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/service_contracts'), $fileName); 
            $serviceContract->contract_file = 'storage/service_contracts/' . $fileName; 
        }
        
        $serviceContract->save();

        return $serviceContract;
    }
}
