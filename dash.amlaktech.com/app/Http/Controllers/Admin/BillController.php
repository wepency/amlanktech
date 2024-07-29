<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Bill\StoreBillHandler;
use App\Http\Actions\Bill\UpdateBillHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bill\StoreBillRequest;
use App\Http\Requests\Bill\UpdateBillRequest;
use App\Models\Association;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function index()
    {
        $bills = Bill::orderBy('id', 'DESC');

        if (is_manager()) {
            $bills = $bills->where('association_id', auth()->user()->association_id);
        }

        $bills = $bills->paginate(PAGINATION_LENGTH);

        return view('Admin.Bills.index', [
            'page_title' => 'سندات الصرف',
            'bills' => $bills,
        ]);
    }


    public function create(Request $request, Bill $bill): JsonResponse
    {

        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Bills.create', [
                'page_title' => 'إضافة  سند صرف',
                'url' => dashboard_route('bills.store'),
                'bill' => $bill,
                'associations' => $associations
            ])->render()
        ]);
    }


    public function edit(Bill $bill): JsonResponse
    {
        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Bills.create', [
                'page_title' => 'تعديل سند الصرف',
                'url' => dashboard_route('bills.update', $bill->id),
                'bill' => $bill,
                'associations' => $associations
            ])->render()
        ]);
    }


    public function store(StoreBillRequest $request)
    {
        (new StoreBillHandler($request))->handle();

        return redirect()->back()->with('success', 'Bill created successfully');
    }

    public function update(UpdateBillRequest $request, Bill $bill)
    {
        (new UpdateBillHandler($request, $bill))->handle();
        return redirect()->back()->with('success', 'Bill updated successfully');
    }


    public function show($id)
    {
        $bill = Bill::findOrFail($id);

        return view('Admin.Bills.show', [
            'page_title' => 'سند صرف / ' . $bill->name,
            'bill' => $bill,
        ]);
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);

        $bill->delete();

        return redirect()->back()->with('success', 'Bill deleted successfully');
    }

}
