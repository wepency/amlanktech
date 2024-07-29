<?php

namespace App\Http\Actions\InvestmentContract;

use App\Models\InvestmentCompanyContract;
use Illuminate\Http\Request;

class StoreInvestmentContractHandler
{

    public function __construct(
        public Request $request
    ){}

    public function handle(): InvestmentCompanyContract
    {
        
        $invetmentContract = new InvestmentCompanyContract();
        $invetmentContract->investment_type= $this->request->get('investment_type');
        $invetmentContract->amount = $this->request->get('amount');
        $invetmentContract->company_id = $this->request->get('company_id');

        if ($this->request->hasFile('contract_file')) {
            $file = $this->request->file('contract_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/investment_contracts'), $fileName); 
            $invetmentContract->contract_file = 'storage/investment_contracts/' . $fileName; 
        }

        $invetmentContract->save();

        return $invetmentContract;
    }
}
