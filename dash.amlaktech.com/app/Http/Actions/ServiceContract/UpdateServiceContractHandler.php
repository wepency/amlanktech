<?php

namespace App\Http\Actions\ServiceContract;

use App\Models\ServiceCompanyContract;
use Illuminate\Http\Request;

class UpdateServiceContractHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public ServiceCompanyContract $serviceContract,
    )
    {
    }

    public function handle(): self
    {
        $this->serviceContract->service_type= $this->request->get('service_type');
        $this->serviceContract->amount = $this->request->get('amount');
        $this->serviceContract->company_id = $this->request->get('company_id');
    
        if ($this->request->hasFile('contract_file')) {
            $file = $this->request->file('contract_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/service_contracts'), $fileName); 
            $this->serviceContract->contract_file = 'storage/service_contracts/' . $fileName; 
        }
        
        $this->serviceContract->save();

        $this->message = 'The User Has Been Updated Successfully';

        return $this;
    }

}
