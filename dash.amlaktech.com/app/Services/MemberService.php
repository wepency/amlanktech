<?php

namespace App\Services;

use App\Models\AssociationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberService
{
    public static function updateOrCreate(Request $request, AssociationMember $member)
    {
        try {

            DB::beginTransaction();

            $memberInfo = $request->only($member->getFillable());

            if ($request->password != '') {
                $memberInfo['password'] = bcrypt($request->password);
            }

            $member = $member->updateOrCreate([
                'id' => $member?->id
            ], $memberInfo);

            DB::commit();

            return $member;

        }catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }

        return false;
    }
}
