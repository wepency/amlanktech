<?php

namespace App\Http\Actions\InvestmentContract;

use App\Models\InvestmentCompanyContract;
use Illuminate\Http\Request;

class UpdateInvestmentContractHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public InvestmentCompanyContract $invetmentContract,
    )
    {
    }

    public function handle(): self
    {
        $this->invetmentContract->name= $this->request->get('name');
        $this->invetmentContract->value = $this->request->get('value');
        $this->invetmentContract->date = $this->request->get('date');
    
        if ($this->request->hasFile('contract_file')) {
            $file = $this->request->file('contract_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/investment_contracts'), $fileName); 
            $this->invetmentContract->contract_file = 'storage/investment_contracts/' . $fileName; 
        }
        
        $this->invetmentContract->save();

        $this->message = 'The User Has Been Updated Successfully';

        return $this;
    }

}
