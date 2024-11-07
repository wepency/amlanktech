<?php

namespace App\Services;

use App\Models\Permit;
use App\Models\PermitCategory;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermitCategoriesService
{
    use DataTableHelperTrait;

    public const SINGLE_MODEL_TITLE = 'permit-category';
    public const PLURAL_MODEL_TITLE = 'permit-categories';

    public const RAW_COLUMNS = [
        'id',
        'name',
        'count',
        'need_approval',
        'actions'
    ];

    public function editColumnNeedApproval()
    {
        return $this->editColumn('need_approval', function ($row) {
            return $row->national_id;
        });
    }

    public function addColumnCount()
    {
        return $this->addColumn('count', function ($row) {
            return $row->permit_count;
        });
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    public function addColumnActions()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $out .= '&nbsp';

            $deleteRoute = dashboard_route('permit_categories.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public static function updateOrCreate(Request $request, PermitCategory $permitCategory)
    {
        $fields = $request->all();

        try {

            DB::beginTransaction();

            $fields['need_approval'] = $request->need_approval == 'on';
            $fields['association_id'] = $request->association_id ?? get_association_id();

            $permitCategory->updateOrCreate([
                'id' => $permitCategory?->id
            ], $fields);

            DB::commit();

            return true;

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
        }

        return false;
    }
}
