<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Bill;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke(){

        $bills         = Bill::count();
        $units         = Unit::count();
        $members       = User::count();
        $associations  = Association::count();
        $subscriptions = Subscription::count();

        $notPaids = Subscription::where('is_paid', false)
                ->whereDate('end_payment', '>', now())
                ->get();
        $notPaidsCount = $notPaids->count();
        $notPaids = $notPaids->sum('total');

        $paids = Subscription::where('is_paid', true)->get();
        $paidsCount = $paids->count();
        $paids = $paids->sum('total');

        $lates = Subscription::where('is_paid', false)
                ->whereDate('end_payment', '<', now())
                ->get();

        $latesCount = $lates->count();
        $lates = $lates->sum('total');

        return view('Admin.Dashboard', [
            'page_title' => 'أهلا بك في لوحة تحكم اتحاد الملاك',
            'bills' => $bills,
            'units' => $units,
            'members' => $members,
            'associations' => $associations,
            'subscriptions' => $subscriptions,
            'notPaids' => $notPaids,
            'paids' => $paids,
            'lates' => $lates,
            'paidsCount' => $paidsCount,
            'notPaidsCount' => $notPaidsCount,
            'latesCount' => $latesCount,

        ]);
    }
}
