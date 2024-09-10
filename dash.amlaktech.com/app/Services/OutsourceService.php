<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Http\Request;

class OutsourceService
{
    public static function updateOrCreate(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|max:191',
            'phone_number' => 'required',
            'association_id' => 'nullable:numeric|exists:associations',
            'email' => 'nullable|email',
            'salary' => 'required|numeric',
            'profession' => 'required',
        ]);

        $adminData = $request->only('name', 'phone_number', 'association_id','email', 'salary', 'profession');

        $adminData['role'] = 'outsource';
        $adminData['association_id'] = $request->association_id ?? getAssociationId();
        $adminData['company_id'] = $request->company_id;

        return $admin->updateOrCreate([
            'id' => $admin->id
        ], $adminData);
    }
}
