<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $companies = Company::withCount('adminAgreement');

        if (!is_admin()) {
            $companies->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {
            $data = (new CompanyService($companies))
                ->editCreatedAtColumn()
                ->editColumnId()
                ->editColumnAddedToBudget()
                ->editColumnAmount()
                ->editColumnFilePath()
                ->addColumnAdminAgreement()
                ->addColumnActions()
                ->rawTableColumns()
                ->getAssociationDetails()
                ->setRowId();

            if ($request->start >= $request->length) {
                $total = $data->totalCount();
                $query = $data->getQuery();
            } else {
                $total = $data->getFilteredQuery()->count();
                $query = $data->getFilteredQuery();
            }

            $addedToBudgetTotal = (clone $query)->where('added_to_budget', 1)->count();

            // Eager load the related admin agreements
            $queryWithAdminAgreements = $query->with('adminAgreement');

            // Get the count of related admin agreements for each row
            $adminAgreementTotal = $queryWithAdminAgreements->get()->map(function ($item) {
                return $item->adminAgreement->count();
            })->sum();

            $data->with([
                'total' => (clone $query)->count(),
                'addedToBudgetTotal' => $addedToBudgetTotal,
                'adminAgreementTotal' => $adminAgreementTotal,
                'amountTotal' => (clone $query)->sum('amount'),
            ]);

            return $data->toJson();
        }

        return view('Admin.Company.Companies.index', [
            'page_title' => 'عقود الشركات الخدمية',
            'singleModel' => 'company',
            'pluralModel' => 'companies'
        ]);
    }

    public function agreements(Company $company)
    {
        return response()->json([
            'data' => view('Admin.Company.Companies._agreements', [
                'page_title' => 'الموافقات',
                'agreements' => $company->adminAgreement
            ])->render()
        ]);
    }

    public function create(Request $request, Company $company)
    {
        return response()->json([
            'data' => view('Admin.Company.Companies.create', [
                'page_title' => 'اضافة عقد شركة',
                'company' => $company,
                'url' => dashboard_route('companies.store'),
            ])->render()
        ]);
    }

    public function store(Request $request, Company $company)
    {
        try {
            return $this->redirectBack($this->updateOrCreate($request, $company));
        }catch (\Exception $exception) {
            report($exception);
        }

        return $this->redirectBack(false);
    }

    public function edit(Request $request, Company $company)
    {
        return response()->json([
            'data' => view('Admin.Company.Companies.create', [
                'page_title' => 'تعديل عقد شركة',
                'company' => $company,
                'url' => dashboard_route('companies.update', $company->id),
            ])->render()
        ]);
    }

    public function update(Request $request, Company $company)
    {
        try {
            return $this->redirectBack($this->updateOrCreate($request, $company));
        }catch (\Exception $exception) {
            report($exception);
        }

        return $this->redirectBack(false);
    }

    public function updateOrCreate(Request $request, Company $company)
    {

        DB::beginTransaction();

        $data = [
            'name' => 'required|string|max:100',
            'association_id' => 'nullable|exists:associations,id|numeric',
            'amount' => 'required|numeric',
            'file_path' => 'nullable|mimes:pdf,docx,doc,xslx,xls',
            'added_to_budget' => 'nullable'
        ];

        $validatedData = $request->validate($data);

        if ($request->hasFile('file_path')) {
            $validatedData['file_path'] = UploadService::upload($request->file('file_path'))['filename'];
        }

        if ($company->exists && !$request->hasFile('file_path')) {
            unset($validatedData['file_path']);
        }

        if (!is_admin()) {
            $validatedData['association_id'] = getAssociationId();
        }

        $validatedData['added_to_budget'] = $request->added_to_budget == 'on';

        $company = $company->updateOrCreate([
            'id' => $company->id
        ], $validatedData);

        if ($company->wasRecentlyCreated) {
            DB::table('companies_admin_agreement')->insert([
                'company_id' => $company->id,
                'admin_id' => get_auth()->id(),
                'created_at' => now()
            ]);
        }

        DB::commit();

        return true;
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        return $this->redirectBack($company->delete());
    }
}
