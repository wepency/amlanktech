<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\ServiceContract\StoreServiceContractHandler;
use App\Http\Actions\ServiceContract\UpdateServiceContractHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceContract\StoreServiceContractRequest;
use App\Http\Rwquests\ServiceContract\UpdateServiceContractRequest;
use App\Models\Company;
use App\Models\ServiceCompanyContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceCompanyContractController extends Controller
{

    public function index()
    {
        $services = ServiceCompanyContract::paginate(PAGINATION_LENGTH);
        $companies = Company::all();

        return view('Admin.Company.ServiceContracts.index', [
            'page_title'=>' عقود الشركات الخدمية',
            'services'=>$services,
            'companies'=>$companies,

        ]);
    }

    public function create(Request $request, ServiceCompanyContract $service): JsonResponse
    {
        $companies = Company::all();
        return response()->json([
            'data' => view('Admin.Company.ServiceContracts.create', [
                'page_title' => 'اضافة عقد خدمي',
                'url' => dashboard_route('services.store'),
                'service' => $service,
                'companies' => $companies,
            ])->render()
        ]);
    }


    public function edit(ServiceCompanyContract $service): JsonResponse
    {

        $companies = Company::all();
        return response()->json([
            'data' => view('Admin.Company.ServiceContracts.create', [
                'page_title' => 'تعديل عقد خدمي',
                'url' => dashboard_route('services.update', $service->id),
                'service' => $service,
                'companies' => $companies,

            ])->render()
        ]);
    }


    public function store(StoreServiceContractRequest $request)
    {
        (new StoreServiceContractHandler( $request))->handle();


        return redirect()->back()->with('success', 'Contract created successfully');
    }

    public function update(UpdateServiceContractRequest $request,ServiceCompanyContract $investment)
    {
        (new UpdateServiceContractHandler( $request , $investment))->handle();


        return redirect()->back()->with('success', 'Contract updated successfully');
    }


    public function downloadContract($id)
    {

        $contract = ServiceCompanyContract::findOrFail($id);
        $filePath = public_path($contract->contract_file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'Contract file not found.');
        }

    }

    public function destroy($id)
    {
        $contract = ServiceCompanyContract::findOrFail($id);

        $contract->delete();

        return redirect()->back()->with('success', 'Contract deleted successfully');
    }

}
