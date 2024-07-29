<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Association;
use App\Models\AssociationMember;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{
    public function memberNewRequest(MemberRequest $request)
    {

        $unit = new Unit;

        try {

            DB::beginTransaction();

            $association = Association::findOrFail($request->association_id);

            $member = AssociationMember::create($request->only('name', 'email', 'password', 'phone_number'));

            $unit->association_id = $request->association_id;
            $unit->association_member_id = $member->id;

            $unit->unit_no = generateUnitCode();

            $unit->fee_type_amount = $request->fee_type_amount;
            $unit->fee_type_total = calculateUnitFees($association->fee_amount, $request->fee_type_amount);

            $unit->ownership_type = $request->ownership_type;

            if ($request->ownership_type == 'group') {
                $unit->ownership_ratio = $request->ownership_ratio;
            }

            $unit->address = $request->address;
            $unit->water_meter_serial = $request->water_meter_serial;
            $unit->electricity_meter_serial = $request->electricity_meter_serial;

            $unit->area = $request->area;

            $unit->save();

            DB::commit();

            auth('member')->loginUsingId($member->id);

            return redirect()->to(url('/waiting-approval'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'برجاء التأكد من البيانات المدخلة.')->withInput($request->all());
        }
    }
}
