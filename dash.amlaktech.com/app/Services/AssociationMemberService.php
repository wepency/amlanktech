<?php

namespace App\Services;

use App\Models\AssociationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssociationMemberService
{
    public function updateOrCreate(Request $request, AssociationMember $associationMember)
    {
        $member = new AssociationMember;

//        $member->association_id = $this->request->get('association_id');

        $data = $request->only('name', 'email', 'phone_number', 'password', 'fee_type_amount');

        if ($request->password != '') {
            $data['password'] = Hash::make($request->passwrord);
        }else {
            unset($data['password']);
        }

        $member->save();
    }
}
