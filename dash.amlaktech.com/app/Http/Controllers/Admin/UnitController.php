<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUnitRequest;
use App\Models\Association;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{

    public function index(Request $request, Unit $units)
    {
        if ($request->member_id != '') {
            $units = $units->where('association_member_id', $request->member_id);
        }

        if ($request->association_id != '') {
            $units = $units->where('association_id', $request->association_id);
        }

        $units = getOnlyObjectsAccordingToAdmin($units, 'association_id')->paginate(30);

        $unitsCount = $units->total();

        $associations = Association::select('name', 'id')->orderBy('name', 'asc')->get();

        return view('Admin.Units.Index', [
            'page_title' => 'الوحدات',
            'units' => $units,
            'unitsCount' => $unitsCount,
            'associations' => $associations
        ]);
    }

    public function create(Request $request, Unit $unit)
    {
        $associations = Association::orderBy('name', 'asc')->get();
        $members = $this->getMembers();

        return response()->json([

            'data' => view('Admin.Units.create', [

                'page_title' => 'إضافة وحدة',
                'url' => dashboard_route('units.store'),
                'unit' => $unit,
                'members' => $members,
                'associations' => $associations

            ])->render()
        ]);
    }

    public function store(StoreUnitRequest $request, Unit $unit)
    {

        try {

            if (UnitService::updateOrCreate($request, $unit)) {
                return redirect()->back()->withSuccess('تم اضافة الوحدة بنجاح.');
            }

        } catch (\Exception $exception) {
            report($exception);
        }

        return redirect()->back()->withError('هناك خطأ في انشاء الوحدة.');
    }

    public function edit(Request $request, Unit $unit)
    {
        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Units.create', [
                'page_title' => 'تعديل الوحدة',
                'url' => dashboard_route('units.update', $unit->id),
                'unit' => $unit,
                'members' => $this->getMembers(),
                'associations' => $associations
            ])->render()
        ]);
    }

    public function update(StoreUnitRequest $request, Unit $unit)
    {

        try {

            if (UnitService::updateOrCreate($request, $unit)) {
                return redirect()->back()->withSuccess('تم تعديل الوحدة بنجاح.');
            }

        } catch (\Exception $exception) {
            report($exception);
        }

        return redirect()->back()->withError('هناك خطأ في تعديل الوحدة.');

    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        $unit->delete();

        return redirect()->back()->with('success', 'unit deleted successfully');
    }


    public function getAssociationFeesIdentifier(Request $request)
    {
        $association = Association::findOrFail($request->association_id);

        return response()->json([
            'data' => $association->feeType->identifier ?? 'المساحة'
        ]);
    }

    private function getMembers()
    {
        return \App\Models\User::active()->orderBy('name', 'asc')->get(['id', 'name', 'phone_number']);
    }
}
