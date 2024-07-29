<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\PaymentReceipt;
use App\Models\ReceiptCategory;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptService
{
    use DataTableHelperTrait;

    public const RAW_COLUMNS = [
        'association',
        'actions',
        'status'
    ];

    public const SINGLE_MODEL_TITLE = 'receipt';
    public const PLURAL_MODEL_TITLE = 'receipts';

    public static function checkStatus($requires_approval)
    {

        if ($requires_approval) {
            return '<h4><span class="badge bg-warning">مقيد</span></h4>';
        }

        return '<h4><span class="badge bg-success">غير مقيد</span></h4>';
    }

    public function addColumnStatus()
    {
        return $this->addColumn('status', function ($row) {
            if ($row->status == '') {
                return '<h4><span class="badge bg-warning">مقيد</span></h4>';
            }

            return '<h4><span class="badge bg-success">فعال</span></h4>';
        });
    }

    public function editCreatedAtColumn()
    {
        return $this->editColumn('created_at', function ($row) {
            return $row->created_at->format('Y-m-d H:i');
        });
    }

    public function editColumnPaymentType()
    {
        return $this->editColumn('payment_type', function ($row) {
            return trans('labels.' . $row->payment_type);
        });
    }

    public function editColumnAmount()
    {
        return $this->editColumn('amount', function ($row) {
            return $row->amount . 'ر.س';
        });
    }

    public function addColumnActions()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            if (\request()->type == 'requests') {
                $acceptRoute = dashboard_route('payment-receipts.accept', $row->id);
                $out .= static::acceptButton($acceptRoute);
            }

            $deleteRoute = dashboard_route('income-receipts.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public static function acceptButton($route)
    {
        $out = "<form method='post' action={$route} style='display:inline-block;margin:0'>";
        $out .= csrf_field();
        $out .= method_field('put');

        $out .= '<button type="submit" class="btn btn-success accept-row" data-toggle="tooltip"
                                                    title="قبول السند">
                                                    <i class="fas fa-check-circle"></i>
                 </button>';

        $out .= '</form>';

        return $out;
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    /**
     * @throws \Exception
     */
    public static function updateOrCreate(Request $request, PaymentReceipt $paymentReceipt, $receiptType = 'payment')
    {

        DB::beginTransaction();

        $associationId = getAssociationId() ?? $request->association_id;

        $category = ReceiptCategory::find($request->receipt_category_id);
        $status = 1;

        $requires_approval = $category?->requires_approval && !$paymentReceipt->exists;

        if ($requires_approval) {
            $status = null;
            $requires_approval = true;
        }

        if (!$requires_approval && $request->amount >= 5000) {
            throw new \Exception('المبلغ يجب أن يكون بين 1 ريال الى 4999 ريال ، لإضافة سند أعلى استخدم سند قيد.');
        }

        $data = $request->merge([
            'association_id' => $associationId,
            'status' => $status,
            'receipt_type' => $receiptType
        ])->only('title', 'association_id', 'status','receipt_type', 'date', 'receipt_category_id', 'payment_type', 'amount', 'notes');

        $paymentReceipt = $paymentReceipt->updateOrCreate([
            'id' => $paymentReceipt?->id
        ], $data);

        if (!$requires_approval) {

            $amount = $paymentReceipt->amount;
            $amount = $receiptType == 'payment' ? $amount * -1 : $amount;

            BudgetService::storeNewBudgetRow([
                'model_type' => get_class($paymentReceipt),
                'model_id' => $paymentReceipt->id,
                'type' => $receiptType,
                'amount' => $amount,
                'association_id' => $associationId,
                'status' => 'approved'
            ]);

        }

        DB::commit();

        if ($requires_approval) {
            $manager = Admin::where('association_id', getAssociationId())->where('role', 'manager')->orderBy('id', 'asc')->first();

            if (!is_null($manager)) {
                $phoneNumber = filter_phone_number($manager->phone_number);
                return sendSMS($phoneNumber, ' هناك سند صرف مقيد بانتظار التفعيل، برجاء المراحعة.'. rand(111,999));
            }
        }

        return true;
    }

    public static function destroy($paymentReceipt)
    {
        DB::beginTransaction();

        $paymentReceipt->budget()->update([
            'status' => 'declined'
        ]);

        $paymentReceipt->destroy($paymentReceipt);

        DB::commit();

        return true;
    }
}
