<?php

namespace App\Services;

use App\Traits\DataTableHelperTrait;

class CompanyService
{
    use DataTableHelperTrait;

    public const RAW_COLUMNS = [
        'association',
        'added_to_budget',
        'file_path',
        'admin_agreements',
        'actions'
    ];

    private const SINGLE_MODEL_TITLE = 'company';
    private const PLURAL_MODEL_TITLE = 'companies';

    public function editCreatedAtColumn()
    {
        return $this->editColumn('created_at', function ($row) {
            return $row->created_at->format('Y-m-d H:i:s');
        });
    }

    public function editColumnAddedToBudget()
    {
        return $this->editColumn('added_to_budget', function ($row) {
            if ($row->added_to_budget)
                return '<span class="text-success"><i class="si si-check-circle"></i> مضاف </span>';

            return '<span class="text-danger"><i class="si fa fa-times-circle"></i> غير مضاف </span>';
        });
    }

    public function editColumnAmount()
    {
        return $this->editColumn('added_to_budget', function ($row) {
            return currency($row->amount);
        });
    }

    public function editColumnFilePath()
    {
        return $this->editColumn('file_path', function ($row) {
            if (!is_null($row->file_path))
                return '<a class="btn btn-success" target="_blank" href="' . asset('uploads/' . $row->file_path) . '"><i class="fa fa-download"></i></a>';

            return '--';
        });
    }

    public function addColumnActions()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $deleteRoute = dashboard_route('companies.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public function addColumnAdminAgreement()
    {
        return $this->addColumn('admin_agreements', function ($row) {
            return '<button type="button" class="btn btn-link show-agreements"
                                                data-toggle="tooltip" title="عرض الموافقات"
                                                data-bs-toggle="modal"
                                                data-bs-target="#agreements">'.$row->adminAgreement()->count().'</button>';
        });
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }
}
