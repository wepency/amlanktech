<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Member\StoreMemberHandler;
use App\Http\Actions\Member\UpdateMemberHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Association;
use App\Models\AssociationMember;
use App\Models\AssociationsMembers;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AssociationMemberController extends Controller
{

    public function index(Request $request)
    {
        $members = User::with('association', 'association.feeType')->withCount('units');

        if (!is_admin()) {
            $members = $members->whereHas('association', function ($query){
                return $query->where('id', getAssociationId());
            });
        }

        $associations = Association::select('name', 'id')->orderBy('name', 'asc')->get();

        if ($request->type == 'requests') {
            $members = $members->whereNull('status');
        } else {
            $members = $members->whereNotNull('status');
        }

        if ($request->ajax()) {
            return DataTables::eloquent($members)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return pad_code($row->id);
                })
                ->addColumn('name', function ($row) {
                    return "<p class='text-success m-0'>" . $row?->name . "</p>";
                })
                ->addColumn('association', function ($row) {
                    $out = '';

                    if(count($row->associations) > 0) {
                        $out .= '<ul>';

                        foreach($row->associations as $association) {
                            $out .= '<li><span class="badge bg-primary">'.$association->name.'</span></li>';
                        }

                        return $out .= '</ul>';
                    }

                    return 'غير منتمي لاي جمعية';
                })
                ->addColumn('units_count', function ($row) {
                    return $row->units_count;
                })
                ->editColumn('status', function ($row) {
                    return get_badge($row->status);
                })
                ->addColumn('action', function ($row) {
                    $out = '<div class="table-buttons">';
//                    $out .= '<a class="btn btn-primary btn-icon" href="'.dashboard_route('units.edit', $row->id).'" data-toggle="tooltip" title="تعديل الوحدة"><i class="fa fa-edit"></i></a>';

                    if (\request()->type != 'requests') {
                        $out .= '<button type="button" class="btn btn-primary edit-member-btn"
                                                data-toggle="tooltip" title="تعديل"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add-edit-members">
                                            <i class="far fa-edit"></i>
                                        </button>';
                    } else {

                        $out .= '<form method="post" action="' . route('dashboard.members.accept', ['member' => $row->id]) . '" style="display:inline-block;margin:0">';
                        $out .= csrf_field();
                        $out .= method_field('PUT');
                        $out .= '<button type="submit" class="btn btn-success accept" data-toggle="tooltip"
                                                    title="قبول"><i class="fas fa-check"></i></button>';
                        $out .= '</form>';

                    }

                    $out .= '<form method="post" action="' . route('dashboard.members.destroy', ['member' => $row->id]) . '" style="display:inline-block;margin:0">';
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
                            return $query->whereHas('association', function ($query){
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
                ->rawColumns(['id', 'name', 'association', 'units_count', 'status', 'action'])
                ->toJson();
        }

        return view('Admin.Users.AssociationMembers.Index', [
            'page_title' => 'الملاك',
            'members' => $members,
            'associations' => $associations
        ]);
    }

    public function create(Request $request, AssociationMember $member): JsonResponse
    {
        $associations = Association::all();
        $cities = City::all();

        return response()->json([
            'data' => view('Admin.Users.AssociationMembers.create', [

                'page_title' => 'إضافة مالك جديد',
                'url' => dashboard_route('members.store'),
                'member' => $member,
                'cities' => $cities,
                'associations' => $associations,
                'memberAssociations' => []

            ])->render()
        ]);
    }

    public function edit(AssociationMember $member): JsonResponse
    {
        $associations = Association::all();
        $cities = City::all();

        return response()->json([
            'data' => view('Admin.Users.AssociationMembers.create', [

                'page_title' => 'تعديل المالك',
                'url' => dashboard_route('members.update', $member->id),
                'member' => $member,
                'cities' => $cities,
                'associations' => $associations,
                'memberAssociations' => $member->associations()->pluck('id')->toArray()

            ])->render()
        ]);
    }

    public function store(StoreMemberRequest $request)
    {

        (new StoreMemberHandler($request))
            ->handle();

        return redirect()->back()->with('success', 'Association Member created successfully');
    }

    public function update(UpdateMemberRequest $request, AssociationMember $member)
    {

        (new UpdateMemberHandler($request, $member))
            ->handle();

        return redirect()->back()->with('success', 'Association Member updated successfully');
    }

    public function accept(AssociationMember $member)
    {

        try {
            DB::beginTransaction();

            $member = AssociationMember::findOrFail($member->id);
            $member->status = 1;
            $member->save();

            $member->units()->first()->update([
                'status' => 1
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Member Deleted successfully');

        } catch (\Exception $exception) {

            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());

        }

    }

    public function destroy(AssociationMember $member)
    {
        $member = AssociationMember::findOrFail($member->id);
        $member->delete();
        return redirect()->back()->with('success', 'Member Deleted successfully');
    }
}
