<?php

namespace App\Services;

use App\Models\PermitBlock;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;

class PermitBlockService
{
    use DataTableHelperTrait;

    public const SINGLE_MODEL_TITLE =  'permit-block';
    public const PLURAL_MODEL_TITLE = 'permit-blocks';

    public const RAW_COLUMNS = [
        'id',
        'phonenumber',
        'association',
        'actions',
        'association'
    ];

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    public function addColumnNationalId()
    {
        return $this->addColumn('national_id', function ($row){
            return $row->national_id;
        });
    }

    public function addColumnAction()
    {
        return $this->addColumn('actions', function ($row) {
            $deleteRoute = dashboard_route('permits.blocklist.destroy', $row->id);
            return static::deleteButton($deleteRoute);
        });
    }

    public static function updateOrCreate(Request $request, PermitBlock $receiptCategory)
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
