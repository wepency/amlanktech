<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\PaymentReceipt;
use App\Models\ReceiptCategory;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class IncomeReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $receipts = PaymentReceipt::with('association')->whereReceiptType('income');

        if (!is_admin()) {
            $receipts->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {
            return (new ReceiptService($receipts))
                ->editCreatedAtColumn()
                ->editColumnId()
                ->getAssociationDetails()
                ->editColumnPaymentType()
                ->editColumnAmount()
                ->addColumnActions()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();
        }

        return view('Admin.income_receipts.index', [
            'page_title' => trans('labels.receipts'),
            'receipts' => $receipts,
            'singleModel' => ReceiptService::SINGLE_MODEL_TITLE,
            'pluralModel' => ReceiptService::PLURAL_MODEL_TITLE,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PaymentReceipt $paymentReceipt)
    {
        $categories = ReceiptCategory::where('receipt_type', 'income');
        $manager = null;

        if (!is_admin()) {
            $associationId = getAssociationId();
            $categories->whereAssociationId(getAssociationId());

            $association = Association::select('id')->find($associationId);
            $manager = $association?->manager;
        }

        $categories = $categories->orderBy('name', 'desc')->get(['name', 'id', 'requires_approval']);

        return response()->json([
            'data' => view('Admin.income_receipts.create', [
                'page_title' => 'انشاء سند قبض',
                'url' => dashboard_route('income-receipts.store'),
                'receipt' => $paymentReceipt,
                'categories' => $categories,
                'manager' => $manager
            ])->render(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PaymentReceipt $paymentReceipt)
    {
        try {
            return $this->redirectBack(ReceiptService::updateOrCreate($request, $paymentReceipt, 'income'));
        } catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack($exception);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentReceipt $incomeReceipt)
    {
        $categories = ReceiptCategory::where('receipt_type', 'income');
        $manager = null;

        if (!is_admin()) {
            $associationId = getAssociationId();
            $categories->whereAssociationId(getAssociationId());

            $association = Association::select('id')->find($associationId);
            $manager = $association?->manager;
        }

        $categories = $categories->orderBy('name', 'desc')->get(['name', 'id', 'requires_approval']);

        return response()->json([
            'data' => view('Admin.income_receipts.create', [
                'page_title' => 'تعديل سند القبض',
                'url' => dashboard_route('income-receipts.update', $incomeReceipt?->id),
                'receipt' => $incomeReceipt,
                'categories' => $categories,
                'manager' => $manager
            ])->render(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            return $this->redirectBack(ReceiptService::updateOrCreate($request, $paymentReceipt, 'income'));
        } catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentReceipt $paymentReceipt)
    {
        try {
            return $this->redirectBack(ReceiptService::destroy($paymentReceipt));
        } catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack($exception);
        }
    }
}
