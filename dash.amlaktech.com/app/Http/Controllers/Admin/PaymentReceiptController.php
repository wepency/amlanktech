<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\PaymentReceipt;
use App\Models\ReceiptCategory;
use App\Services\BudgetService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isRequest = $request->type == 'requests';
        $page_title = trans('labels.' . ($isRequest ? 'hold-payment-receipts' : 'payment-receipts'));

        $receipts = PaymentReceipt::with('association')->whereReceiptType('payment');

        if (!is_admin()) {
            $receipts->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {

            if ($isRequest) {
                $receipts->whereStatus(null);
            } else {
                $receipts->whereStatus(1);
            }

            return (new ReceiptService($receipts))
                ->editCreatedAtColumn()
                ->editColumnId()
                ->getAssociationDetails()
                ->editColumnPaymentType()
                ->editColumnAmount()
                ->addColumnStatus()
                ->addColumnActions()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();
        }

        return view('Admin.payment_receipts.index', [
            'page_title' => $page_title,
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
        $categories = ReceiptCategory::where('receipt_type', 'payment');

        $manager = null;

        if (!is_admin()) {
            $associationId = getAssociationId();
            $categories->whereAssociationId(getAssociationId());

            $association = Association::select('id')->find($associationId);
            $manager = $association?->manager;
        }

        $categories = $categories->orderBy('name', 'desc')->get(['name', 'id', 'requires_approval']);

        return response()->json([
            'data' => view('Admin.payment_receipts.create', [
                'page_title' => 'انشاء سند قبض',
                'url' => dashboard_route('payment-receipts.store'),
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
//        return ReceiptService::updateOrCreate($request, $paymentReceipt);
        try {
            return $this->redirectBack(ReceiptService::updateOrCreate($request, $paymentReceipt));
        } catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack(false)->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentReceipt $paymentReceipt)
    {
        $categories = ReceiptCategory::where('receipt_type', 'payment');
        $manager = null;

        if (!is_admin()) {
            $associationId = getAssociationId();
            $categories->whereAssociationId(getAssociationId());

            $association = Association::select('id')->find($associationId);
            $manager = $association?->manager;
        }

        $categories = $categories->orderBy('name', 'desc')->get(['name', 'id', 'requires_approval']);

        return response()->json([
            'data' => view('Admin.payment_receipts.create', [
                'page_title' => 'تعديل سند القبض',
                'url' => dashboard_route('payment-receipts.update', $paymentReceipt?->id),
                'receipt' => $paymentReceipt,
                'categories' => $categories,
                'manager' => $manager
            ])->render(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentReceipt $paymentReceipt)
    {
        try {
            return $this->redirectBack(ReceiptService::updateOrCreate($request, $paymentReceipt));
        } catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack($exception);
        }
    }

    public function accept(PaymentReceipt $paymentReceipt)
    {
        try {

            DB::beginTransaction();

            $paymentReceipt->status = 1;
            $paymentReceipt->save();

            BudgetService::storeNewBudgetRow([
                'model_type' => get_class($paymentReceipt),
                'model_id' => $paymentReceipt->id,
                'type' => 'payment',
                'amount' => $paymentReceipt->amount,
                'association_id' => $paymentReceipt->association_id,
                'status' => 'approved'
            ]);

            DB::commit();

            return $this->redirectBack();

        } catch (\Exception $exception) {
            DB::rollBack();
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
