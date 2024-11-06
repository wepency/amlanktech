<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermitRequest;
use App\Models\Permit;
use App\Models\PermitCategory;
use App\Services\PermitService;
use App\Traits\AssociationTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermitsController extends Controller
{
    use AssociationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Permit $permits)
    {
        return $this->permitsIndex($request, $permits);
    }

    /**
     * Display a listing of the permits which needs to be approved.
     */
    public function requests(Request $request, Permit $permits)
    {
        $permits = $permits->whereNull('status');
        return $this->permitsIndex($request, $permits, 'requests');
    }

    private function permitsIndex(Request $request, $permits, $type = null)
    {
        $permits = $permits->with('association', 'member', 'visitors');

        $associationId = auth('admin')->user()->association_id ?? request()->association_id;

        if ($associationId != '') {
            $permits = $permits->where('association_id', $associationId);
        }

        if ($request->ajax()) {

            return DataTables::eloquent($permits)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return pad_code($row->id);
                })
                ->editColumn('start_date', function ($row) {
                    return optional($row->start_date)->format('d-m-Y');
                })
                ->addColumn('owner', function ($row) {
                    return "<p class='text-success m-0'>" . $row?->member?->name ?? 'محذوف' . "</p>";
                })
                ->addColumn('association', function ($row) {
                    return '<p class="m-0">' . $row?->association?->name . '</p>';
                })
                ->addColumn('visitors', function ($row) {
                    $visitors = $row->visitors;
                    $out = '<ul>';

                    foreach ($visitors as $visitor) {
                        $out .= '<li class="m-0">' . $visitor->visitor_name . '</li>';
                    }

                    $out .= '</ul>';

                    return $out;
                })
                ->editColumn('status', function ($row) {
                    return get_badge($row->status);
                })
                ->addColumn('action', function ($row) {
                    $out = '<div class="table-buttons">';

                    $out .= '<a href="' . dashboard_route('permits.show', $row?->code) . '" class="btn btn-success" target="_blank">
                                            <i class="far fa-eye"></i>
                                        </a>';

                    $out .= '<button type="button" class="btn btn-primary edit-permit-btn"
                                                data-toggle="tooltip" title="تعديل"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add-edit-permits">
                                            <i class="far fa-edit"></i>
                                        </button>';

                    $out .= '<form method="post" action="' . route('dashboard.permits.destroy', $row->id) . '" style="display:inline-block;margin:0">';
                    $out .= csrf_field();
                    $out .= method_field('delete');
                    $out .= '<button type="submit" class="btn btn-danger delete" data-toggle="tooltip"
                                                    title="الحذف"><i class="fas fa-trash"></i></button>';
                    $out .= '</form>';

                    return $out;
                })
                ->filter(function ($query) use ($request) {

                    if ($request->association != '') {
                        $query->where('association_id', $request->association);
                    }

                }, true)
                ->orderColumn('association', function ($query, $order) {
                    $query->orderBy('association_id', $order);
                })
                ->orderColumn('id', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->filter(function ($query) use ($request) {
//                    if ($request->search != '') {
//                        $query->where('name', 'like', '%' . $request->search . '%')
//                            ->orWhere('phone_number', 'like', '%' . $request->search . '%')
//                            ->orWhere('email', 'like', '%' . $request->search . '%');
//                    }

                    if ($request->association != '') {
                        $query->where('association_id', $request->association);
                    }

                }, true)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->rawColumns(['id', 'owner', 'association', 'visitors', 'status', 'action'])
                ->toJson();
        }

        return view('Admin.Permits.Index', [
            'page_title' => 'التصاريح',
            'permits' => $permits,
            'type' => $type
        ]);
    }

    private function getPermitCategories()
    {
        $categories = PermitCategory::query();

        if (!is_admin()) {
            $categories = $categories->where('association_id', get_association_id());
        }

        return $categories->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Permit $permit)
    {
        return response()->json([
            'data' => view('Admin.Permits.create', [
                'page_title' => 'تصريح جديد',
                'permit' => $permit,
                'url' => route('dashboard.permits.store'),
                'categories' => $this->getPermitCategories(),
                'visitors' => [
                    [
                        'name' => '',
                        'national_id' => ''
                    ]
                ],
                'members' => $this->getMembers()
            ])->render()
        ]);
    }

    public function show($permitCode)
    {
        $permit = Permit::where('code', $permitCode)->firstOrFail();

        return view('Permit', [
            'page_title' => 'تصريح دخول ' . $permit->code,
            'permit' => $permit
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermitRequest $request, Permit $permit)
    {
        return $this->redirectBack(PermitService::updateOrCreate($request, $permit));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permit $permit)
    {
        return response()->json([
            'data' => view('Admin.Permits.create', [
                'page_title' => 'تعديل التصريح',
                'permit' => $permit,
                'url' => route('dashboard.permits.update', $permit->id),
                'visitors' => $permit->visitors,
                'categories' => $this->getPermitCategories(),
                'members' => $this->getMembers()
            ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermitRequest $request, Permit $permit)
    {
        return $this->redirectBack(PermitService::updateOrCreate($request, $permit));
    }

    public function visitorsRow()
    {
        return response()->json([
            'data' => view('Admin.Permits._visitors_create')->render()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permit $permit)
    {
        return $this->redirectBack($permit->delete());
    }
}
