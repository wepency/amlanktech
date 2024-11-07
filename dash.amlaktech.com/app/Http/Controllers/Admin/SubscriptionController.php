<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Unit;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index()
    {
        $subscriptions = Subscription::query();

        if (!is_admin()) {
            $subscriptions = getOnlyObjectsAccordingToAdmin($subscriptions, 'association_id');
        }

        $subscriptions = $subscriptions->paginate();

        $subscriptionsCount = $subscriptions->total();

        $associations = Association::all();
        $units = Unit::all();
        $subscriptionTypes = SubscriptionType::all();

        return view('Admin.Subscriptions.Index', [
            'page_title' => 'الاشتراكات',
            'subscriptions' => $subscriptions,
            'associations' => $associations,
            'units' => $units,
            'subscriptionTypes' => $subscriptionTypes,
            'subscriptionsCount' => $subscriptionsCount,
        ]);
    }


    public function store(Request $request, Subscription $subscription)
    {
        $calculatedFee = $this->calculateSubscriptionFee($request);

        $validatedData = $this->createOrUpdate($request);

        $validatedData['is_paid'] = $request->input('is_paid');
        $validatedData['total'] = $calculatedFee;

        if ($request->amount != '') {
            $validatedData['amount'] = $request->amount;
            $validatedData['total'] = $request->amount;
        }

        Subscription::create($validatedData);

        return redirect()->route('dashboard.subscriptions.index')->with('success', 'Subscription created successfully');
    }


    public function update(Request $request, Subscription $subscription)
    {
//        $subscription = Subscription::findOrFail($id);

        $updatedFee = $this->calculateSubscriptionFee($request);

        $validatedData = $this->createOrUpdate($request);

        $validatedData['is_paid'] = $request->input('is_paid');
        $validatedData['total'] = $updatedFee;

        if ($request->amount != '') {
            $validatedData['amount'] = $request->amount;
            $validatedData['total'] = $request->amount;
        }

        $subscription->update($validatedData);

        return redirect()->back()->with('success', 'Subscription updated successfully');
    }

    private function createOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'association_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'subscription_type_id' => 'required',
            'start_payment' => 'required|date',
            'end_payment' => 'required|date',

        ]);

        return $validatedData;
    }

    private function calculateSubscriptionFee($request)
    {
        $subscriptionType = $request->input('subscription_type_id');

        $association = Association::findOrFail($request->input('association_id'));
        $unitFee = $association->unit_fee_per_meter;
        $familyFee = $association->family_fee;
        $personFee = $association->person_fee;
        $carFee = $association->car_fee;

        $unit = Unit::findOrFail($request->input('unit_id'));
        $units = $unit->area;
        $persons = $unit->unit_memebers;
        $families = $unit->unit_families;
        $cars = $unit->car_numbers;

        $fee = 0;
        switch ($subscriptionType) {
            case SubscriptionType::UNIT :
                $fee = $unitFee * $units;
                break;

            case SubscriptionType::PERSON :
                $fee = $personFee * $persons;
                break;

            case SubscriptionType::FAMILY :
                $fee = $familyFee * $families;
                break;

            case SubscriptionType::CAR :
                $fee = $carFee * $cars;
                break;

        }

        return $fee;
    }


    public function notPaid()
    {

        $associations = Association::all();
        $units = Unit::all();
        $subscriptionTypes = SubscriptionType::all();

        $lateSubscriptions = Subscription::where('is_paid', false)
            ->whereDate('end_payment', '>', now())
            ->paginate(10);

        $subscriptionsCount = $lateSubscriptions->count();

        return view('Admin.Subscriptions.NotPaid', [
            'page_title' => 'الاستحقاقات',
            'subscriptions' => $lateSubscriptions,
            'associations' => $associations,
            'units' => $units,
            'subscriptionsCount' => $subscriptionsCount,
            'subscriptionTypes' => $subscriptionTypes,
        ]);
    }

    public function paid()
    {

        $associations = Association::all();
        $units = Unit::all();
        $subscriptionTypes = SubscriptionType::all();

        $lateSubscriptions = Subscription::where('is_paid', true)->paginate(10);
        $subscriptionsCount = $lateSubscriptions->count();

        return view('Admin.Subscriptions.Paid', [
            'page_title' => 'المدفوعات',
            'subscriptions' => $lateSubscriptions,
            'associations' => $associations,
            'units' => $units,
            'subscriptionsCount' => $subscriptionsCount,
            'subscriptionTypes' => $subscriptionTypes,
        ]);
    }

    public function late()
    {

        $associations = Association::all();
        $units = Unit::all();
        $subscriptionTypes = SubscriptionType::all();

        $currentDate = now();

        $lateSubscriptions = Subscription::where('is_paid', false)
            ->whereDate('end_payment', '<', $currentDate)
            ->paginate(10);

        $subscriptionsCount = $lateSubscriptions->count();

        return view('Admin.Subscriptions.Late', [
            'page_title' => 'المتأخرات',
            'subscriptions' => $lateSubscriptions,
            'associations' => $associations,
            'units' => $units,
            'subscriptionTypes' => $subscriptionTypes,
            'subscriptionsCount' => $subscriptionsCount,
        ]);
    }

    public function destroy(Subscription $subscription)
    {

        $subscription = Subscription::findOrFail($subscription->id);
        $subscription->delete();
        return redirect()->back()->with('success', 'Subscription Deleted successfully');

    }


}
