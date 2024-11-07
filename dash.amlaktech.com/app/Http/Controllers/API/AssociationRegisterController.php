<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Association;
use App\Services\PaymentService;
use App\Traits\generateAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssociationRegisterController extends Controller
{
    use generateAPI;

    public function store(Request $request)
    {
        $request->validate([
            'association_name' => 'required',
            'map_link' => 'nullable|url',
            'registration_number' => 'required',
            'subscription_period' => '',
            'subscription_start_date' => '',
            'address' => 'required',
            'manager_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'national_id' => 'required|numeric'
        ]);

        try {

            DB::beginTransaction();

            // Association
            $association = Association::create([
                'name' => request('association_name'),
                'map_link' => request('map_link'),
                'registration_number' => request('registration_number'),
                'subscription_period' => request('subscription_period'),
                'subscription_start_date' => now()->format('Y-m-d'),
                'address' => request('address')
            ]);

            // Association Manager
            $associationManager = Admin::create([
                'name' => request('manager_name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
                'association_id' => $association->id,
                'phone_number' => request('phone_number'),
                'role' => 'manager',
                'national_id' => request('national_id'),
                'address' => request('address')
            ]);

            $association->update([
                'admin_id' => $associationManager->id
            ]);

            DB::commit();

            return $this->success([
                'message' => 'تم اضافة الجمعية بنجاح، التوجه الى صفحة الدفع',
                'payment_link' => (new PaymentService)->payInfo("111123", 100, 'https://amlacktech.com'),
                'association' => $association
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->error([$exception->getMessage()]);
        }

    }
}
