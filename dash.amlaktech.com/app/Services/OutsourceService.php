<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Http\Request;

class OutsourceService
{
    public static function updateOrCreate(Request $request, Admin $admin)
    {
        $adminData = $request->only('name', 'phone_number', 'association_id','email', 'salary', 'profession');

        $adminData['role'] = 'outsource';

        return $admin->updateOrCreate([
            'id' => $admin->id
        ], $adminData);
    }
}
