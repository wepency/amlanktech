<?php

namespace App\Services;

use App\Models\Poll;
use App\Traits\DataTableHelperTrait;
use Illuminate\Http\Request;

class PollService
{
    use DataTableHelperTrait;

    public const RAW_COLUMNS = [
        'name',
        'association',
        'createdBy',
        'items',
        'votes',
        'actions'
    ];

    public const SINGLE_MODEL_TITLE = 'poll';
    public const PLURAL_MODEL_TITLE = 'polls';

    public function addColumnCreatedBy()
    {
        return $this->addColumn('created_by', function ($row) {
            return $row->user?->name;
        });
    }

    public function editCreatedAtColumn()
    {
        return $this->editColumn('created_at', function ($row) {
            return $row->created_at->format('Y-m-d H:i');
        });
    }

    public function addColumnItems()
    {
        return $this->addColumn('items', function ($row) {
            $out = "";

            if (count($row->items)) {
                foreach ($row->items as $item) {
                    $out .= "<li>$item->title</li>";
                }

                $out .= "<a>عرض الخيارات</a>";
            }

            return $out;
        });
    }

    public function addColumnVotes()
    {
        return $this->addColumn('votes', function ($row) {
            return count($row->votes);
        });
    }

    public function addColumnActions()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $deleteRoute = dashboard_route('income-receipts.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    /**
     * @throws \Exception
     */
    public static function updateOrCreate(Request $request, Poll $poll)
    {

    }

    public static function destroy($paymentReceipt)
    {

    }
}
