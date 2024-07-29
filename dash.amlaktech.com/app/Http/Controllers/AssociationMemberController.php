<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\AssociationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssociationMemberController extends Controller
{
    public function store(Request $request, AssociationMember $associationMember)
    {
        $data = $request->only(['name', 'email', 'password', 'association_id']);

        $data['password'] = Hash::make($request->password);

        $associationMember = Association::create($data);
    }
}
