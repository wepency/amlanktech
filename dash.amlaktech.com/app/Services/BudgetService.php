<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Gift;
use App\Models\PaymentReceipt;
use App\Models\Subscription;
use App\Traits\DataTableHelperTrait;

class BudgetService
{
    use DataTableHelperTrait;

    public const RAW_COLUMNS = [
        'association',
        'model_name',
        'amount',
    ];

    public const MORPH_TYPES = [
        PaymentReceipt::class,
        Subscription::class,
        Gift::class
    ];

    public function editCreatedAtColumn()
    {
        return $this->editColumn('created_at', function ($row) {
            return $row->created_at->format('Y-m-d H:i:s');
        });
    }

    public function editColumnAmount()
    {
        return $this->editColumn('amount', function ($row) {
            $amount = $row->amount;

            if ($amount > 0) {
                $iconClass = "fa-arrow-up";
                $textColor = "text-success";
            } else {
                $amount = $row->amount * -1;
                $iconClass = "fa-arrow-down";
                $textColor = "text-danger";
            }

            return '<span class="' . $textColor . '"><i class="fa ' . $iconClass . '"></i> ' . currency($amount) . '</span>';
        });
    }

    public function addColumnModelName()
    {
        return $this->addColumn('model_name', function ($row) {
            if (!is_null($row->model_type))
                return $row->model->getTitle();

            return '--';
        });
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }

    public static function storeNewBudgetRow(array $data)
    {
        if (Budget::create($data)) {
            cache()->forget('budget_' . $data['association_id']);
            self::updateCache($data['association_id']);

            return true;
        }

        return false;
    }

    public static function updateCache($associationId)
    {
        if (!cache()->has('budget_' . $associationId)) {
            cache()->remember('budget_' . $associationId, 60, function () use ($associationId) {
                return Budget::whereAssociationId($associationId)->sum('amount');
            });
        }
    }

    public function filterBudget()
    {
        return $this->filter(function ($query) {
            match (request()->type) {
                'income' => $query->where('model_type', PaymentReceipt::class)->where('amount', '>', 0),
                'payment' => $query->where('model_type', PaymentReceipt::class)->where('amount', '<', 0),
                'subscriptions' => $query->where('model_type', Subscription::class),
                'gifts' => $query->where('model_type', Gift::class),
                default => $query
            };
        }, true);
    }

    public function getAssociationDetails()
    {
        return $this->addColumn('association', function ($row) {

            if (!is_null($row->association)) {
                if (!is_null($row->association->trashed()))
                    return '<p class="m-0 text-danger">' . $row?->association?->name . ' (محذوفة)</p>';

                return '<p class="m-0">' . $row?->association?->name . '</p>';
            }

            return '--';
        });
    }
}
