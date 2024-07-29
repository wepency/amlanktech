<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends Controller
{
    public function requests(Request $request)
    {
        $units = Unit::with('association', 'association.feeType', 'associationMember')->whereNull('status');

        if (!is_admin()) {
            $units = $units->where('association_id', getAssociationId());
        }

        $associations = Association::select('name', 'id')->orderBy('name', 'asc')->get();

        if ($request->ajax()) {
            $data = DataTables::eloquent($units)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return pad_code($row->id);
                })
                ->addColumn('name', function ($row) {
                    $out = '<a href="' . dashboard_route('units.index', ['member_id' => $row->association_member_id]) . '" class="mb-0"><i class="fa fa-check-circle text-success"></i>';
                    $out .= '<strong>' . ($row?->associationMember?->name ?? 'غير معروف') . '</strong></a>';
                    return $out;
                })
                ->addColumn('phone_number', function ($row) {
                    return $row->associationMember->phone_number ?? '--';
                })
                ->editColumn('partners_amount', function ($row) {
                    return $row->partners_amount ?? 'لا يوجد شركاء';
                })
                ->addColumn('ownership_type', function ($row) {
                    $out = '<p class="text-danger">';

                    if ($row->ownership_type == 'group') {
                        $out .= '<i class="fa fa-users"></i> &nbsp;';
                    } else {
                        $out .= '<i class="fa fa-user"></i> &nbsp;';
                    }

                    $out .= __('labels.ownership.' . $row->ownership_type);

                    return $out .= '</p>';
                })
                ->editColumn('ownership_ratio', function ($row) {
                    return ($row->ownership_ratio ?? 100) . '%';
                })
                ->editColumn('fee_type_total', function ($row) {
                    return currency($row->fee_type_total * $row?->association?->subscription_period);
                })
                ->addColumn('association', function ($row) {
                    if (!is_null($row->association)) {
                        if (!is_null($row->association->trashed()))
                            return '<p class="m-0 text-danger">' . $row?->association?->name . ' (محذوفة)</p>';

                        return '<p class="m-0">' . $row?->association?->name . '</p>';
                    }

                    return '--';
                })
                ->addColumn('action', function ($row) {
                    $out = '<div class="table-buttons">';

                    $out .= '<button type="button" data-bs-toggle="modal" data-bs-target="#accept-unit" class="btn btn-success accept-unit-btn" data-toggle="tooltip" title="قبول"><i class="fas fa-check"></i></button>';

                    $out .= '<form method="post" action="' . route('dashboard.units.destroy', $row->id) . '" style="display:inline-block;margin:0">';
                    $out .= csrf_field();
                    $out .= method_field('delete');
                    $out .= '<button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                                    title="الحذف"><i class="fas fa-trash"></i></button>';
                    $out .= '</form>';

                    return $out;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->association != '') {
                        if (is_admin()) {
                            return $query->whereHas('association', function ($query) {
                                return $query->where('id', getAssociationId());
                            });
                        }
                    }
                }, true)
                ->orderColumn('association', function ($query, $order) {
                    $query->orderBy('association_id', $order);
                })
                ->orderColumn('member_fees', function ($query, $order) {
                    $query->orderBy('fee_type_amount', $order);
                })
                ->orderColumn('id', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->rawColumns(['id', 'name', 'association', 'ownership_type', 'ownership_ratio', 'partners_amount', 'action', 'fee_type_total']);

            return $data->with([
                'total' => $data->totalCount()
            ])->toJson();
        }

        return view('Admin.Requests', [
            'page_title' => 'طلبات انضمام الملاك',
            'associations' => $associations
        ]);
    }

    public function acceptModal(Unit $unit)
    {
        return response()->json([
            'data' => view('Admin.Request-accept', [
                'page_title' => 'قبول الطلب',
                'url' => dashboard_route('units.accept', $unit->id),
                'unit' => $unit
            ])->render()
        ]);
    }

    public function accept(Request $request, Unit $unit)
    {

        $subStartDate = Carbon::parse($request->valid_to)->format('Y-m-d');

        try {

            DB::beginTransaction();

            $unit->update([
                'status' => 1,
                'sub_start_date' => $subStartDate
            ]);

            $unit->associationMember()->update([
                'status' => 1
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'تم قبول الطلب بنجاح.');

        } catch (\Exception $exception) {

            DB::rollBack();
            report($exception);

        }

        return redirect()->back()->with('error', 'هناك مشكلة في قبول الطلب، برجاء المحاولة لاحقا.');
    }
}
