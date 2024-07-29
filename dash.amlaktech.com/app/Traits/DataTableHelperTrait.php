<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;

/**
 * Trait DataTableHelperTrait
 * @package App\Traits
 */
trait DataTableHelperTrait
{
    /**
     * @var EloquentDataTable
     */
    protected EloquentDataTable $dataTable;

    /**
     * DataTableHelperTrait constructor.
     * @param mixed $query The Eloquent query to be used by the data table.
     */
    public function __construct(mixed $query)
    {
        $this->dataTable = DataTables::eloquent($query);
    }

    /**
     * Create a new instance of the DataTableHelperTrait.
     * @param mixed $query The Eloquent query to be used by the data table.
     * @return static
     */
    public static function DataTable(mixed $query)
    {
        return new static($query);
    }

    /**
     * Edit the specified column using the provided callback.
     *
     * @param string $column The name of the column to edit.
     * @param \Closure $callback The callback function to modify the column.
     *
     * @return $this
     */
    public function editColumn(string $column, \Closure $callback): self
    {
        // Your implementation for editing a column
        $this->dataTable->editColumn($column, $callback);

        return $this;
    }

    public function addColumn(string $column, \Closure $callback): self
    {
        // Your implementation for creating a column
        $this->dataTable->addColumn($column, $callback);

        return $this;
    }

    public function editColumnId(): self
    {
        return $this->editColumn('id', function ($row) {
            return pad_code($row->id);
        });
    }

    public function rawColumns(array $columns): self
    {
        $this->dataTable->rawColumns($columns);

        return $this;
    }

    /**
     * Convert the data table to JSON format.
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJson(): JsonResponse
    {
        return $this->dataTable->toJson();
    }

    public function getAssociationDetails()
    {
        return $this->addColumn('association', function ($row) {
            if (!is_null($row->association))
                return '<p class="m-0">' . $row?->association?->name . '</p>';

            return '--';
        });
    }

    protected static function editButton($singleModel, $pluralModel)
    {
        return '<button type="button" class="btn btn-primary edit-'.$singleModel.'-btn"
                                                data-toggle="tooltip" title="تعديل"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add-edit-'.$pluralModel.'">
                                            <i class="far fa-edit"></i>
                                        </button>';
    }

    protected static function deleteButton($route)
    {
        $out = "<form method='post' action={$route} style='display:inline-block;margin:0'>";
        $out .= csrf_field();
        $out .= method_field('delete');

        $out .= '<button type="submit" class="btn btn-danger delete" data-toggle="tooltip"
                                                    title="الحذف">
                                                    <i class="fas fa-trash"></i>
                 </button>';

        $out .= '</form>';

        return $out;
    }

    public function setRowId()
    {
        return $this->dataTable->setRowId(function ($row) {
            return $row->id;
        });
    }

    public function totalCount()
    {
        return $this->dataTable->totalCount();
    }

    public function getQuery()
    {
        return $this->dataTable->getQuery();
    }

    public function getFilteredQuery()
    {
        return $this->dataTable->getFilteredQuery();
    }

    public function filter(callable $callback, $globalSearch = false)
    {
        $this->dataTable->filter($callback, $globalSearch);
        return $this;
    }

    public function with($key, $value = '')
    {
        return $this->dataTable->with($key, $value = '');
    }
}
