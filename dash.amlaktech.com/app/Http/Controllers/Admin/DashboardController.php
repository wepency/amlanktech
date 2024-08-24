<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Bill;
use App\Models\PaymentReceipt;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke(){

        $units         = Unit::query();
        $members       = User::query();

        $associations  = Association::count();

        $subscriptions = Subscription::query();

        $notPaids = Subscription::where('is_paid', false)
                ->whereDate('end_payment', '>', now());

        $paids = Subscription::where('is_paid', true);

        $lates = Subscription::where('is_paid', false)
                ->whereDate('end_payment', '<', now());

        $latesCount = $lates->count();
        $lates = $lates->sum('total');

        // Receipts
        $paymentReceipts = PaymentReceipt::count();

        if (!is_admin()) {
            $associationId = getAssociationId();

            $units = getOnlyObjectsAccordingToAdmin($units, $associationId);
            $members = $members->whereHas('association', function ($query){
                return $query->where('id', getAssociationId());
            });

            $subscriptions = $subscriptions;

            $notPaids = getOnlyObjectsAccordingToAdmin($notPaids, $associationId);
            $paids = getOnlyObjectsAccordingToAdmin($paids, $associationId);
        }

        // All counts
        $units = $units->count();
        $members = $members->count();
        $subscriptions = $subscriptions->count();
        $notPaidsCount = $notPaids->count();
        $notPaids = $notPaids->sum('total');
        $paidsCount = $paids->count();
        $paids = $paids->sum('total');

        return view('Admin.Dashboard', [
            'page_title' => 'أهلا بك في لوحة تحكم اتحاد الملاك',
            'paymentReceipts' => $paymentReceipts,
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
