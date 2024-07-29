<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketCategoryService
{
    use DataTableHelperTrait;

    public const SINGLE_MODEL_TITLE = 'ticket-category';
    public const PLURAL_MODEL_TITLE = 'ticket-categories';

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
            return $row->status == 1 ? 'مفعل' : 'غير مفعل';
        });
    }

    public function addColumnAction()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $deleteRoute = dashboard_route('ticket-categories.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public static function updateOrCreate(Request $request, TicketCategory $ticketCategory)
    {
        $request->merge([
            'requires_approval' => $request->requires_approval == 'on',
            'association_id' => get_auth()->user()->association_id ?? $request->association_id
        ]);

        return $ticketCategory->updateOrCreate([
            'id' => $ticketCategory?->id
        ], $request->all());
    }
}
