<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\OTP;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function form()
    {
        $associations = Association::orderBy('name', 'ASC')->get();

        return view('Admin.Login', [
            'page_title' => 'تسجيل الدخول'
        ]);
    }

    public function postLogin(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = false;

        if (is_numeric($request->username)) {
            $user = auth('admin')->attempt(['phone_number' => $request->username, 'password' => $request->password]);
        } else if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $user = auth('admin')->attempt(['email' => $request->username, 'password' => $request->password]);
        }

        $userGuard = auth('admin')->user();

        if ($user) {

//            $otp = rand(1000, 9999);
//
//            OTP::updateOrCreate([
//                'phonenumber' => $userGuard->phone_number,
//            ], [
//                'phonenumber' => $userGuard->phone_number,
//                'otp' => $otp
//            ]);

//            sendSMS(ltrim($userGuard->phone_number, 0), 'كود دخول تطبيق أملاك الخاص بك: ' . $otp);

            return redirect(dashboard_route('home'));
        }

        return redirect()->back()->withInput($request->all())->withError('البيانات المدخلة غير صحيحة.');
    }

    public function otpForm(Request $request)
    {
        return view('Admin.OTP');
    }

    public function checkOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $otp = implode('', $request->otp);

        if ($otpRow = OTP::where('phonenumber', auth('admin')->user()->phone_number)->where('otp', $otp)->first()) {
            $request->session()->put('2fa', true);
            $otpRow->delete();

            return redirect(dashboard_route('home'));
        }

        return redirect()->back()->withErrors(['otp' => 'كود التحقق غير صحيح، برجاء اعادة المحاولة.']);
    }
}
