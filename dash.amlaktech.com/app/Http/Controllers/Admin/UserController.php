<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\User\StoreUserHandler;
use App\Http\Actions\User\UpdateUserHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Admin;
use App\Models\Association;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = Admin::employees()->with('association');

        $associationId = auth('admin')->user()->association_id ?? request()->association_id;

        if ($associationId != '') {
            $users = $users->where('association_id', $associationId);
        }

        if ($request->ajax()) {

            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return pad_code($row->id);
                })
                ->addColumn('name', function ($row) {
                    return "<p class='text-success m-0'>" . $row->name . "</p>";
                })
                ->addColumn('association', function ($row) {
                    return '<p class="m-0">' . $row?->association?->name . '</p>';
                })
                ->editColumn('status', function ($row) {
                    return get_badge($row->status);
                })
                ->addColumn('action', function ($row) {
                    $out = '<div class="table-buttons">';
//                    $out .= '<a class="btn btn-primary btn-icon" href="'.dashboard_route('units.edit', $row->id).'" data-toggle="tooltip" title="تعديل الوحدة"><i class="fa fa-edit"></i></a>';

                    $out .= '<button type="button" class="btn btn-primary edit-user-btn"
                                                data-toggle="tooltip" title="تعديل"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add-edit-users">
                                            <i class="far fa-edit"></i>
                                        </button>';

                    $out .= '<form method="post" action="' . route('dashboard.employees.destroy', $row->id) . '" style="display:inline-block;margin:0">';
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
                    if ($request->search != '') {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('phone_number', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    }
//
                    if ($request->association != '') {
                        $query->where('association_id', $request->association);
                    }

                }, true)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->rawColumns(['id', 'name', 'association', 'status', 'action'])
                ->toJson();
        }

        return view('Admin.Users.Users.Index', [
            'page_title' => 'الموظفون',
            'users' => $users,
        ]);
    }

    public function create(Request $request, Admin $employee): JsonResponse
    {
        $associations = Association::orderBy('name', 'asc')->get();
        $roles = Role::query();

        if ($request->association_id) {
            $roles = $roles->where('association_id', $request->association_id)->orWhereNull('association_id');
        }

        $roles = $roles->get();

        return response()->json([
            'data' => view('Admin.Users.Users.create', [
                'page_title' => 'إضافة موظف',
                'url' => dashboard_route('employees.store'),
                'user' => $employee,
                'associations' => $associations,
                'roles' => $roles
            ])->render()
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        (new StoreUserHandler($request))->handle();
        return redirect()->back()->with('success', 'User created successfully');
    }

    public function edit(Request $request, Admin $employee): JsonResponse
    {
        $associations = Association::orderBy('name', 'asc')->get();

        $roles = Role::query();

        if ($request->association_id) {
            $roles = $roles->where('association_id', $request->association_id)->orWhereNull('association_id');
        }

        $roles = $roles->get();

        return response()->json([
            'data' => view('Admin.Users.Users.create', [
                'page_title' => 'تعديل موظف',
                'url' => dashboard_route('employees.update', $employee->id),
                'user' => $employee,
                'associations' => $associations,
                'roles' => $roles
            ])->render()
        ]);
    }

    public function update(UpdateUserRequest $request, Admin $employee)
    {
        (new UpdateUserHandler($request, $employee))->handle();
        return redirect()->back()->with('success', 'User updated successfully');
    }


    public function destroy(Admin $employee)
    {

        try {
            $employee->delete();
            return redirect()->back()->withSuccess('تم حذف الموظف بنجاح.');
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return redirect()->back()->withError('هناك مشكلة في حذف الموظف.');
    }
}
