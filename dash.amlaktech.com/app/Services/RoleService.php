<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Str;

class RoleService
{
    const SINGLE_MODEL_TITLE = 'role';
    const PLURAL_MODEL_TITLE = 'roles';

//$role_name = Str::slug($request->role);
//Role::where('name', $role_name)->exists();

    public static function generateRoleName($roleName)
    {
        $roleName = Str::slug($roleName) . rand(1, 999);

        if (Role::where('name', $roleName)->exists()) {
            return self::generateRoleName($roleName);
        }

        return $roleName;
    }

    public static function updateOrCreate($request, $role)
    {
        $mainName = $request->role;

        $roleName = static::generateRoleName($request->role);

        $role = Role::updateOrCreate(['id' => $role->id], ['name' => $roleName, 'main_name' => $mainName, 'guard_name' => 'admin', 'association_id' => getAssociationId()]);

//            foreach ($request->permission as $permission){
        $role->syncPermissions($request->permission);

        return redirect()->back()->withSuccess('Permissions Added Successfully');
    }
}
