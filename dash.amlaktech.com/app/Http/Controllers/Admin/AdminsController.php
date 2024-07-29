<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\AdminService;
use App\Traits\RoleTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminsController extends Controller
{

    use RoleTrait;

    /**
     * Display a listing of the Admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {

        $admins = Admin::admins()->orderBy('id', 'Asc')->paginate(PAGINATION_LENGTH);

        return view('Admin.Users.Admins.Index', [
            'page_title' => 'المديرين',
            'admins' => $admins
        ]);
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, Admin $admin): JsonResponse
    {

        return response()->json([
            'data' => view('Admin.Users.Admins.create', [
                'page_title' => 'إضافة مدير جديد',
                'url' => dashboard_route('admins.store'),
                'admin' => $admin,
                'roles' => $this->getRole()
            ])->render()
        ]);
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param \App\Http\Requests\Admin\StoreAdminRequest $request
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAdminRequest $request, Admin $admin): RedirectResponse
    {

        try {

            $request->merge(['role' => 'admin']);
            AdminService::createOrUpdate($request, $admin);
            return back()->withSuccess('Admin created successfully');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('هناك مشكلة في إضافة المدير.');
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Admin $admin): JsonResponse
    {
        return response()->json([
            'data' => view('Admin.Users.Admins.create', [
                'page_title' => 'تعديل المدير',
                'url' => dashboard_route('admins.update', $admin->id),
                'admin' => $admin,
                'roles' => $this->getRole()
            ])->render()
        ]);
    }

    /**
     * Update the specified admin in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate(
            (new UpdateAdminRequest())->rules($admin)
        );

        try {
            AdminService::createOrUpdate($request, $admin);
            return back()->withSuccess('تم تعديل المدير بنجاح.');
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('هناك مشكلة في تعديل المدير.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        if ($admin->delete())
            return back()->withSuccess('Admin Deleted successfully');

        return back()->withError('Admin Deleted successfully');
    }
}
