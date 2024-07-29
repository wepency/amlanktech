<?php

namespace App\Services;

use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminService implements AdminInterface
{
    public static function CreateOrUpdate(Request $request, Admin $admin)
    {
        $fields = $request->only((new Admin)->getFillable());

        foreach ($fields as $key => $field) {
            if ($field == '')
                unset($fields[$key]);

            if ($key == 'password' && $field != '')
                $fields['password'] = Hash::make($request->password);
        }

        $admin->syncRoles([$request->role_group]);

        return $admin->updateOrCreate([
            'id' => $admin?->id
        ], $fields);
    }
}
