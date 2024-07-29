<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutsourceUsers\StoreOutsourceRequest;
use App\Http\Requests\OutsourceUsers\UpdateOutsourceRequest;
use App\Models\Admin;
use App\Models\Association;
use App\Services\OutsourceService;
use Illuminate\Support\Facades\Log;

class OutsourceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Admin::outsourceEmployees()->orderBy('id', 'desc')->paginate(PAGINATION_LENGTH);

        return view('Admin.Users.OutsourceUsers.Index', [
            'page_title' => 'الموظفون',
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Admin $admin)
    {
        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Users.OutsourceUsers.create', [
                'page_title' => 'إضافة موظف خارج النظام',
                'url' => dashboard_route('outsource_employees.store'),
                'user' => $admin,
                'associations' => $associations
            ])->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutsourceRequest $request, Admin $outsource_employees)
    {
        try {

            OutsourceService::updateOrCreate($request, $outsource_employees);
            return redirect()->back()->withSuccess('تم إضافة الموظف بنجاح.');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return redirect()->back()->withError('هناك مشكلة في إضافة الموظف.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $outsourceEmployees = Admin::findOrFail($id);
        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Users.OutsourceUsers.create', [
                'page_title' => 'تعديل موظف خارج النظام',
                'url' => dashboard_route('outsource_employees.update', $outsourceEmployees->id),
                'user' => $outsourceEmployees,
                'associations' => $associations
            ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutsourceRequest $request, int $id)
    {
        try {

            $outsourceEmployees = Admin::findOrFail($id);
            OutsourceService::updateOrCreate($request, $outsourceEmployees);
            return redirect()->back()->withSuccess('تم تعديل الموظف بنجاح.');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return redirect()->back()->withError('هناك مشكلة في تعديل الموظف.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {

            if (Admin::findOrFail($id)->delete())
                return redirect()->back()->withSuccess('تم حذف الموظف بنجاح.');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return redirect()->back()->withError('هناك مشكلة في حذف الموظف.');
    }
}
