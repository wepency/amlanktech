<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\InvestmentContract\StoreInvestmentContractHandler;
use App\Http\Actions\InvestmentContract\UpdateInvestmentContractHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentContract\StoreInvestmentContractRequest;
use App\Http\Requests\InvestmentContract\UpdateInvestmentContractRequest;
use App\Models\Company;
use App\Models\InvestmentCompanyContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvestmentCompanyContractController extends Controller
{
     
    public function index()
    {
        $investments = InvestmentCompanyContract::paginate(PAGINATION_LENGTH); 

        return view('Admin.Company.InvestmentContracts.index', [
            'page_title'=>' عقود الشركات الاستثمارية',
            'investments'=>$investments,
        ]); 
    }

    public function create(Request $request, InvestmentCompanyContract $investment): JsonResponse
    {
        $companies = Company::all();
        return response()->json([
            'data' => view('Admin.Company.InvestmentContracts.create', [
                'page_title' => 'اضافة  عقد استثمارى',
                'url' => dashboard_route('investments.store'),
                'investment' => $investment,
                'companies' => $companies,
            ])->render()
        ]);
    }


    public function edit(InvestmentCompanyContract $investment): JsonResponse
    {

        $companies = Company::all();
        return response()->json([
            'data' => view('Admin.Company.InvestmentContracts.create', [
                'page_title' => 'تعديل عقد استثمارى',
                'url' => dashboard_route('investments.update', $investment->id),
                'investment' => $investment,
                'companies' => $companies,

            ])->render()
        ]);
    }


    public function store(StoreInvestmentContractRequest $request)
    {
        (new StoreInvestmentContractHandler( $request))->handle();


        return redirect()->back()->with('success', 'Contract created successfully');
    }
    
    public function update(UpdateInvestmentContractRequest $request,InvestmentCompanyContract $investment)
    {
        (new UpdateInvestmentContractHandler( $request , $investment))->handle();


        return redirect()->back()->with('success', 'Contract updated successfully');
    }


    public function downloadContract($id)
    {

        $contract = InvestmentCompanyContract::findOrFail($id);
        $filePath = public_path($contract->contract_file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'Contract file not found.');
        }

    }

    public function destroy($id)
    {
        $contract = InvestmentCompanyContract::findOrFail($id);

        $contract->delete();

        return redirect()->back()->with('success', 'Contract deleted successfully');
    }

}
