<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Admin;
use App\Models\Association;
use App\Services\AdminService;
use App\Traits\RoleTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AssociationManagerController extends Controller
{

    use RoleTrait;

    /**
     * Display a listing of the Association Manager.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {

        $managers = Admin::managers()->with('association');

        $roles = Role::query();

        if (!is_admin()) {
            $roles = $roles->where(function ($query) {
                return $query->where('association_id', getAssociationId())
                    ->orWhereNull('association_id');
            });

            $managers = $managers->where('association_id', getAssociationId());
        }

        if ($request->filled('group')) {
            $managers = $managers->whereHas('roles', function ($query) use ($request) {
                $query->where('name', $request->group);
            });
        }

        $managers = $managers->orderBy('id', 'Asc')->paginate(PAGINATION_LENGTH);

        $roles = $roles->whereNull('deleted_at')->get();

        return view('Admin.Users.Managers.Index', [
            'page_title' => 'أعضاء الجمعية',
            'managers' => $managers,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new Association Manager.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, Admin $manager): JsonResponse
    {
        return response()->json([
            'data' => view('Admin.Users.Managers.create', [
                'page_title' => 'إضافة عضو جمعية',
                'url' => dashboard_route('managers.store'),
                'manager' => $manager,
                'associations' => $this->associations(),
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
    public function store(StoreManagerRequest $request, Admin $manager): RedirectResponse
    {

        try {

            $hide = $request->hide_admin ? now() : null;

            $request->merge(['role' => 'manager', 'deleted_at' => $hide]);
            AdminService::createOrUpdate($request, $manager);
            return back()->withSuccess('Association created successfully');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('هناك مشكلة في إضافة مدير الجمعية.');
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param \App\Models\Admin $manager
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Admin $manager): JsonResponse
    {
        return response()->json([
            'name' => $this->associations($manager->association_id),
            'data' => view('Admin.Users.Managers.create', [
                'page_title' => 'تعديل مدير جمعية',
                'url' => dashboard_route('managers.update', $manager->id),
                'manager' => $manager,
                'associations' => $this->associations($manager->association_id),
                'roles' => $this->getRole()
            ])->render()
        ]);
    }

    /**
     * Update the specified admin in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $manager
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Admin $manager): RedirectResponse
    {
        $request->validate(
            (new UpdateManagerRequest())->rules($manager)
        );

        try {
            AdminService::createOrUpdate($request, $manager);
            return back()->withSuccess('تم إضافة مدير الجمعية بنجاح.');
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('هناك مشكلة في تعديل مدير الجمعية.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param \App\Models\Admin $manager
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Admin $manager): RedirectResponse
    {
        if ($manager->delete())
            return back()->withSuccess('Admin Deleted successfully');

        return back()->withError('Admin Deleted successfully');
    }

    private function associations($association = null)
    {
        return Association::orderBy('name', 'asc')
            ->where(function ($query) use ($association) {

                if (!is_null($association)) {
                    $query = $query->orWhere('id', $association);
                }

                return $query;
            })->get();
    }
}
