<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\AssociationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function form()
    {
        if (auth('member')->check())
            return redirect(url('/'));

        $associations = Association::orderBy('id', 'ASC')->get();

        return view('Login', [
            'page_title' => 'تسجيل الدخول',
            'associations' => $associations
        ]);
    }

    public function postLogin(Request $request)
    {
        if (!auth('member')->attempt($request->only(['email', 'password'])))
            return redirect()->back()->withInput()->withErrors(['email' => 'البريد الإلكتروني او كلمة المرور غير صحيحة']);

        return redirect(url('/'));
    }

    public function waitingApproval()
    {
        return view('Frontend.Pages.waiting-approval');
    }

    public function postLogout(Request $request)
    {
        auth('member')->logout();
        return redirect(url('/'));
    }

}
