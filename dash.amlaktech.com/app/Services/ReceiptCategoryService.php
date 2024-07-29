<?php

namespace App\Services;

use App\Models\ReceiptCategory;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;

class ReceiptCategoryService
{
    use DataTableHelperTrait;

    public const SINGLE_MODEL_TITLE =  'receipt-category';
    public const PLURAL_MODEL_TITLE = 'receipt-categories';

    public const RAW_COLUMNS = [
        'id',
        'status',
        'actions',
        'association'
    ];

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    public function addColumnStatus()
    {
        return $this->addColumn('status', function ($row) {
            return ReceiptService::checkStatus($row->requires_approval);
        });
    }

    public function addColumnAction()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $deleteRoute = dashboard_route('receipt-categories.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public static function updateOrCreate(Request $request, ReceiptCategory $receiptCategory)
    {
        $request->merge([
            'requires_approval' => $request->requires_approval == 'on',
            'association_id' => get_auth()->user()->association_id ?? $request->association_id
        ]);

        return $receiptCategory->updateOrCreate([
            'id' => $receiptCategory?->id
        ], $request->all());
    }
}
