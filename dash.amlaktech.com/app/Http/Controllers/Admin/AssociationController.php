<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Association\StoreAssociationRequest;
use App\Http\Requests\Association\UpdateAssociationRequest;
use App\Http\Requests\StoreManagerRequest;
use App\Models\Admin;
use App\Models\Association;
use App\Models\AssociationMember;
use App\Models\FeeType;
use App\Services\AssociationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AssociationController extends Controller
{
    public function index(Request $request, Association $associations)
    {

        return view('Admin.Associations.Index', [
            'page_title' => 'الجمعيات',
            'associations' => $associations->orderBy('id', 'desc')->paginate(30),
        ]);
    }

    public function create(Request $request, Association $association){
        return response()->json([
            'data' => view('Admin.Associations.create', [
                'page_title' => 'اضافة جمعية جديدة',
                'association' => $association,
                'fees_types' => $this->getFeesTypes(),
                'admins' => Admin::select('name', 'id')->managers()->get(),
                'url' => dashboard_route('associations.store'),
                'manager' => (new Admin)
            ])->render()
        ]);
    }

    public function store(StoreAssociationRequest $request, Association $association)
    {

        try {

            return AssociationService::CreateOrUpdate($request, $association);
//            return back()->withSuccess('Association created successfully');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

//        return back()->withError('There was an error creating this association.');
    }

    public function edit(Request $request, Association $association){
        return response()->json([
            'data' => view('Admin.Associations.create', [
                'page_title' => 'تعديل الجمعية',
                'association' => $association,
                'fees_types' => $this->getFeesTypes(),
                'admins' => Admin::select('name', 'id')->managers()->get(),
                'url' => dashboard_route('associations.update', $association->id)
            ])->render()
        ]);
    }

    public function update(UpdateAssociationRequest $request, Association $association)
    {

        try {

            AssociationService::CreateOrUpdate($request, $association);
            return back()->withSuccess('Association updated successfully.');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('There was an error updating this association.');

    }

    public function managerForm(Admin $manager)
    {
        return response()->json([
            'data' => view('Admin.Users.Managers._form', [
                'type' => 'partial',
                'manager' => $manager,
                'roles' => Role::whereNull('deleted_at')->orderBy('main_name')->get()
            ])->render()
        ]);
    }

    public function memberForm(AssociationMember $member)
    {
        return response()->json([
            'data' => view('Admin.Users.AssociationMembers._form', [
                'type' => 'partial',
                'member' => $member
            ])->render()
        ]);
    }

    public function destroy(Association $association)
    {
        if($association->delete())
            return back()->withSuccess('Association deleted successfully');

        return back()->withError('Association deleted successfully');
    }

    private function getFeesTypes()
    {
        return FeeType::orderBy('type', 'asc')->get();
    }
}
