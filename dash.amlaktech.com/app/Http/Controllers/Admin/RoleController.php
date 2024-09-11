<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Permissions;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
{

    // Role equals permissions group

    public function index()
    {
        $rows = Role::with('association');

        if (!is_admin()) {
            $rows->where('association_id', getAssociationId())->orWhereNull('association_id');
        }

        $rows = $rows->orderBy('id', 'DESC')->paginate();

        return view('Admin.Roles.Index', [
            'page_title' => 'الأدوار',
            'rows' => $rows,
            'rolesCount' => $rows->count(),
            'singleModel' => RoleService::SINGLE_MODEL_TITLE,
            'pluralModel' => RoleService::PLURAL_MODEL_TITLE,
        ]);
    }


    public function create(Role $role)
    {
        $permissions = Permissions::attributes();

        return response()->json([
            'data' => view('Admin.Roles._form', [
                'page_title' => 'اضافة مجموعة صلاحيات',
                'permissionGroups' => $permissions,
                'role' => $role,
                'url' => dashboard_route('roles.store'),
            ])->render()
        ]);
    }

    public function store(Request $request, Role $role)
    {

        $request->validate([
            'role' => 'required',
            'permission' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            $redirect = RoleService::updateOrCreate($request, $role);

            DB::commit();

        } catch (\Exception $e) {
            report($e);
            $redirect = redirect()->back()->withError($e->getMessage());
        }

        return $redirect;
    }

    public function edit(Role $role)
    {
        $permissions = Permissions::attributes();

        $rolePermissions = $role->permissions->pluck('name');

        return response()->json([
            'data' => view('Admin.Roles._form', [
                'page_title' => 'تعديل الصلاحية',
                'permissionGroups' => $permissions,
                'role' => $role,
                'rolePermissions' => $rolePermissions,
                'url' => dashboard_route('roles.update', $role->id),
            ])->render()
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:100',
        ]);

//        return $role;

        try {

            DB::beginTransaction();

            $redirect = RoleService::updateOrCreate($request, $role);

            DB::commit();

        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            $redirect = redirect()->back()->withError($e->getMessage());
        }

        return $redirect;
    }

    public function removeUser($role, Admin $admin)
    {
        return $this->redirectBack($admin->removeRole($role));
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }

}
