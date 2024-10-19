<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Company;
use App\Models\PaymentReceipt;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {

        $units = Unit::query();
        $members = User::query();

        $associations = Association::count();

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

        // Check if there is company agreement needed
        $getCompany = Company::query();

        if (!is_admin()) {

            $units = getOnlyObjectsAccordingToAdmin($units, 'association_id');

            $members = $members->whereHas('association', function ($query) {
                return $query->where('id', getAssociationId());
            });

            $subscriptions = getOnlyObjectsAccordingToAdmin($subscriptions, 'association_id');

            $notPaids = getOnlyObjectsAccordingToAdmin($notPaids, 'association_id');
            $paids = getOnlyObjectsAccordingToAdmin($paids, 'association_id');

            $getCompany = getOnlyObjectsAccordingToAdmin($getCompany, 'association_id');
        }

        // All counts
        $units = $units->count();
        $members = $members->count();
        $subscriptions = $subscriptions->count();
        $notPaidsCount = $notPaids->count();
        $notPaids = $notPaids->sum('total');
        $paidsCount = $paids->count();
        $paids = $paids->sum('total');

        // Get all contracts and agreements
        $getCompany = $getCompany->whereDoesntHave('adminAgreementPivot', function ($query) {
            $query->where('admin_id', get_auth()->id());
        })->get();

        return view('Admin.Dashboard', [
            'page_title' => 'أهلا بك في لوحة تحكم أملاك-تك',
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
            'getCompanyContracts' => $getCompany
        ]);
    }
}
