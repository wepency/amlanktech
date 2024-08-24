<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function index(Request $request, Admin $admin)
    {
        $searchTerm = ltrim($request->input('q'), '0');

        $admin = $admin->select('id', 'name', 'phone_number')->where(function ($q) use ($searchTerm) {
            $q->where('phone_number', 'like', "%$searchTerm%")
                ->orWhere('name', 'like', "%$searchTerm%");
        });

        if (!is_admin())
            $admin = getOnlyObjectsAccordingToAdmin($admin, 'association_id')->where('id', '!=', dashboard_auth()->id());

        return $admin->orderBy('name', 'asc')->get()->map(function ($admin) {
            return [
                'id' => $admin->id,
                'name' => $admin->name . ' - ' . $admin->phone_number
            ];
        });
    }

    public function create(Admin $admin)
    {
        return response()->json([
            'data' => view('Admin.Users.Managers.ajax-form', [
                'page_title' => 'إضافة رئيس جمعية',
                'url' => dashboard_route('managers.store'),
                'manager' => $admin,
                'associations' => [],
                'roles' => []
            ])->render()
        ]);
    }

    public function store(Request $request, Admin $manager)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {

            $request->merge(['role' => 'manager']);
            $admin = AdminService::createOrUpdate($request, $manager);

            $admin->delete();

            return response()->json(['message' => 'تم اضافة المدير بنجاح.', 'data' => $admin]);

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return response()->json(['message' => 'هناك مشكلة في إضافة مدير الجمعية.'], 403);
    }
}
