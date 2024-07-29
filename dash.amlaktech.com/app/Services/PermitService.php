<?php

namespace App\Services;

use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermitService
{
    public static function updateOrCreate(Request $request, Permit $permit)
    {
        $fields = $request->only((new Permit)->getFillable());

        try {

            DB::beginTransaction();

            if (!$permit->exists) {
                $fields['code'] = generateBookingCode();
            }

            foreach ($fields as $key => $field) {
                if ($field == '')
                    unset($fields[$key]);

                if (!is_admin() && !auth('sanctum')->check()) {
                    $fields['association_id'] = get_association_id();
                }

                if ($key == 'status')
                    $fields[$key] = ($field == 'on') ? 1 : null;
            }

            if (!$permit?->category?->needs_approval) {
                $fields['status'] = 1;
            }

            $permit = $permit->updateOrCreate([
                'id' => $permit?->id
            ], $fields);


            self::updateVisitors($request, $permit);

            DB::commit();

            return true;

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
        }

        return false;
    }

    public static function updateVisitors(Request $request, Permit $permit)
    {
        $visitors = [];

        $visitorsCollection = convertJsonToArray($request->visitors);

        foreach ($visitorsCollection as $visitor) {
            $visitors[] = [
                'visitor_name' => $visitor['visitor_name'],
                'national_id' => $visitor['national_id'],
                'permit_id' => $permit->id
            ];

            if ($visitor['national_id'] == '1107521104')
                throw new \Exception('رقم الهوية هذا محظور.');
        }

        $permit->visitors()->delete();
        $permit->visitors()->insert($visitors);
    }
}
