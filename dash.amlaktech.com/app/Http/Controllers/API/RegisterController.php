<?php

namespace App\Http\Controllers\API;

use App\Classes\PhoneNumber;
use App\Http\Controllers\Controller;
use App\Models\AssociationsMembers;
use App\Models\Unit;
use App\Models\User;
use App\Rules\PhoneNumberRule;
use App\Traits\generateAPI;
use App\Traits\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use generateAPI, Token;

    public function __invoke(Request $request)
    {

        try {

            $validateField = [
                'name' => 'required',
                'phone_number' => ['required', 'unique:users', new PhoneNumberRule],
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'association_id' => 'required|numeric',
                'ownership_type' => 'required|in:individual,group',
                'unit_address' => 'required|max:191',
                'water_meter_serial' => 'required|max:191',
                'electricity_meter_serial' => 'required|max:191',
//                'area' => 'required|numeric'
                'partners_amount' => 'nullable|numeric',
            ];

            $request->validate($validateField);

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'phone_number' => PhoneNumber::validatePhoneNumber($request->phone_number)['number'],
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

//            if (AssociationsMembers::where('association_id', $request->association_id)->where('user_id', $user->id)->exists())
//                throw new \Exception('البيانات المدخلة مكررة، برجاء تسجيل الدخول بدلا من انشاء حساب جديد.');

            AssociationsMembers::create([
                'association_id' => $request->association_id,
                'user_id' => $user->id
            ]);

            Unit::create([
                'association_id' => $request->association_id,
                'association_member_id' => $user->id,
                'unit_no' => generateUnitCode(),
                'ownership_type' => $request->ownership_type,
                'address' => $request->unit_address,
                'water_meter_serial' => $request->water_meter_serial,
                'electricity_meter_serial' => $request->electricity_meter_serial,
//                'area' => $request->area
            ]);

            DB::commit();

            auth()->loginUsingId($user->id);
            $token = auth()->user()->createToken('user')->plainTextToken;

            return $this->success([$this->respondWithToken($token)], 'تم تسجيل الحساب وقيد المراجعة، سيتم اعلامكم عند التفعيل.');

        } catch (ValidationException $e) {

            // Customizing the validation error response
            $errors = $e->validator->errors()->toArray();

            return $this->error([$errors], null, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, false, false);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error([$exception->getMessage()]);
    }
}
