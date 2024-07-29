<?php

namespace App\Services;

use App\Http\Requests\Member\StoreMemberRequest;
use App\Models\Association;
use App\Models\AssociationMember;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitService
{
    public static function updateOrCreate(Request $request, Unit $unit)
    {
        try {
            DB::beginTransaction();

            $associationId = is_admin() ? $request->association_id : auth('admin')->user()->association_id;
            $association = Association::findOrFail($associationId);

            // Check member id to assign to the unit
            $memberId = self::associateMember($associationId);
            $memberId = $memberId ? $memberId->id : $request->association_member_id;

            $fields = $request->only((new Unit)->getFillable());

            $unitCode = $unit->unit_no;

            if (is_null($unitCode)) {
                $unitCode = generateUnitCode();
            }

           $unit->updateOrCreate([
                'id' => $unit?->id
            ], array_merge($fields, [
                'unit_no' => $unitCode,
                'association_member_id' => $memberId,
                'fee_type_amount' => $request->fee_type_amount ?? 0,
                'fee_type_total' => calculateUnitFees($association->fee_amount, $request->fee_type_amount),
            ]));

            DB::commit();

            return true;

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }

        return false;
    }

    private static function associateMember($associationId)
    {
        if (\request()->name && \request()->email && \request()->password) {

            request()->merge([
                'association_id' => $associationId
            ]);

            if (request()->validate((new StoreMemberRequest)->rules())) {
                return MemberService::updateOrCreate(request(), new AssociationMember);
            }
        }

        return false;
    }
}
