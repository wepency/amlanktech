<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UnitsResource;
use App\Models\AssociationsMembers;
use App\Models\Unit;
use App\Traits\generateAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UnitsController extends Controller
{
    use generateAPI;

    public function index(Request $request)
    {
        $units = Unit::with('association')->where('association_member_id', get_auth()->id())
            ->when($request->filled('search'), function ($units) use ($request) {
                $units->where(function ($units) use ($request) {
                    $units->where('unit_no', 'like', '%' . $request->search . '%')
                        ->orWhereHas('association', function ($association) use ($request) {
                            $association->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($request->filled('association_id'), function ($units) use ($request) {
                $units->whereHas('association', function ($association) use ($request) {
                    $association->where('id', 'like', $request->association_id);
                });
            });

        $unitsObj = (clone $units)->paginate(30);

        return $this->success([
                'active_units' => (clone $units)->where('status', 1)->count(),
                'blocked_units' => (clone $units)->where('status', 4)->count(),
                'pending_units' => (clone $units)->whereNull('status')->count(),
                'units' => UnitsResource::collection($unitsObj)
            ] + $this->pagination_links($unitsObj));
    }

    public function show(Request $request, Unit $unit)
    {
        if ($unit->association_member_id != get_auth()->id()) {
            abort(401);
        }

        return $this->success(['unit' => UnitsResource::make($unit)]);
    }

    public function store(Request $request, Unit $unit)
    {
        try {

            $validateField = [
                'association_id' => 'required|numeric',
                'ownership_type' => 'required|in:individual,group',
                'partners_amount' => 'nullable|numeric',
                'ownership_ratio' => 'nullable|numeric|min:0|max:100',
                'unit_address' => 'required|max:191',
                'water_meter_serial' => 'required|max:191',
                'electricity_meter_serial' => 'required|max:191',
                'area' => 'required|numeric'
            ];

            $request->validate($validateField);

            if ($this->updateOrCreate($request, $unit)) {
                return $this->success(['تم ارسال طلب العقار بنجاح.']);
            }

        } catch (ValidationException $e) {

            // Customizing the validation error response
            $errors = $e->validator->errors()->toArray();

            return $this->error([$errors], null, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, false, false);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error(['حدث خطأ ما']);
    }

    public function update(Request $request, Unit $unit)
    {
        if ($unit->association_member_id != get_auth()->id()) {
            abort(401);
        }

        try {

            $validateField = [
                'association_id' => 'required|numeric',
                'ownership_type' => 'required|in:individual,group',
                'partners_amount' => 'nullable|numeric',
                'ownership_ratio' => 'nullable|numeric|min:0|max:100',
                'unit_address' => 'required|max:191',
                'water_meter_serial' => 'required|max:191',
                'electricity_meter_serial' => 'required|max:191',
                'area' => 'required|numeric'
            ];

            $request->validate($validateField);

            if ($this->updateOrCreate($request, $unit)) {
                return $this->success(['تم التعديل بنجاح.']);
            }

        } catch (ValidationException $e) {

            // Customizing the validation error response
            $errors = $e->validator->errors()->toArray();

            return $this->error([$errors], null, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, false, false);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error([$exception->getMessage()]);
    }

    public function updateOrCreate(Request $request, Unit $unit)
    {
        $validateField = [
            'association_id' => 'required|numeric',
            'ownership_type' => 'required|in:individual,group',
            'unit_name' => 'required|max:191',
            'unit_address' => 'required|max:191',
            'water_meter_serial' => 'required|max:191',
            'electricity_meter_serial' => 'required|max:191',
//            'area' => 'required|numeric'
        ];

        $request->validate($validateField);

        DB::beginTransaction();

        $unitCode = $unit->unit_no;

        if (is_null($unitCode)) {
            $unitCode = generateUnitCode();
        }

        if (!$unit->exists) {
            AssociationsMembers::updateOrCreate([
                'association_id' => $request->association_id,
                'user_id' => get_auth()->id()
            ], [
                'association_id' => $request->association_id,
                'user_id' => get_auth()->id()
            ]);
        }

        Unit::updateOrCreate([
            'id' => $unit->id
        ], [
            'name' => $request->unit_name,
            'unit_no' => $unitCode,
            'ownership_type' => $request->ownership_type,
            'ownership_ratio' => $request->ownership_ratio,
            'partners_amount' => $request->partners_amount,
            'address' => $request->unit_address,
            'water_meter_serial' => $request->water_meter_serial,
            'electricity_meter_serial' => $request->electricity_meter_serial,
            'fee_type_value' => $request->fee_type_value
        ]);

        DB::commit();

        return true;
    }
}
