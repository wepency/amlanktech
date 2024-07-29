<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Services\BudgetService;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $budget = Budget::query();

//        (clone $budget)->find(12)->update(['amount' => -1500]);

        if (!is_admin()) {
            $budget->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {
            $data = (new BudgetService($budget))
                ->editCreatedAtColumn()
                ->editColumnId()
                ->editColumnAmount()
                ->addColumnModelName()
                ->rawTableColumns()
                ->filterBudget()
                ->getAssociationDetails();

            if ($request->start >= $request->length) {
                $total = $data->totalCount();
                $query = $data->getQuery();
            }else {
                $total = $data->getFilteredQuery()->count();
                $query = $data->getFilteredQuery();
            }

            $incomeTotal = (clone $query)->where('amount', '>', 0)->sum('amount');
            $paymentTotal = (clone $query)->where('amount', '<', 0)->sum('amount');

            $data->with([
                'total' => (clone $query)->sum('amount'),
                'incomeTotal' => $incomeTotal,
                'paymentTotal' => -$paymentTotal
            ]);

            return $data->toJson();
        }

        return view('Admin.Budget.index', [
            'page_title' => 'الميزانية',
            'singleModel' => 'budget',
            'pluralModel' => 'budgets'
        ]);
    }
}
