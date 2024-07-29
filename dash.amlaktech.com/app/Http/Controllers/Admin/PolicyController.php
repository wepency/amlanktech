<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Policy\StorePolicyHandler;
use App\Http\Actions\Policy\UpdatePolicyHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Policy\StorePolicyRequest;
use App\Http\Requests\Policy\UpdatePolicyRequest;
use App\Models\Association;
use App\Models\Policy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolicyController extends Controller
{

    public function index()
    {
        $policies = Policy::query();

        if (!is_admin()) {
            $policies = $policies->whereAssociationId(get_association_id());
        }

        $policies = $policies->orderBy('id', 'DESC')->paginate(PAGINATION_LENGTH);

        return view('Admin.Policies.Index', [
            'page_title' => 'اللوائح',
            'policies' => $policies,
        ]);
    }

    public function create(Request $request, Policy $policy): JsonResponse
    {

        $associations = Association::all();

        return response()->json([
            'data' => view('Admin.Policies.create', [
                'page_title' => 'اضافة  لائحة جديدة',
                'url' => dashboard_route('policies.store'),
                'policy' => $policy,
                'associations' => $associations,

            ])->render()
        ]);
    }

    public function edit(Policy $policy): JsonResponse
    {

        $associations = Association::all();

        return response()->json([
            'data' => view('Admin.Policies.create', [
                'page_title' => 'تعديل لائحة',
                'url' => dashboard_route('policies.update', $policy->id),
                'policy' => $policy,
                'associations' => $associations,

            ])->render()
        ]);
    }

    public function store(StorePolicyRequest $request)
    {
        (new StorePolicyHandler($request))->handle();

        return redirect()->back()->with('success', 'Policy created successfully');
    }

    public function update(UpdatePolicyRequest $request, Policy $policy)
    {
        (new UpdatePolicyHandler($request, $policy))->handle();
        return redirect()->back()->with('success', 'Policy updated successfully');
    }

    public function downloadPolicyFile($id)
    {
        $policy = Policy::findOrFail($id);
        $filePath = storage_path('app/public/' . $policy->policy_file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->withErrors(['policy_file' => 'Policy file not found.']);
        }
    }

    public function destroy($id)
    {
        $policy = Policy::findOrFail($id);

        $policyFilePath = storage_path('app/public/' . $policy->policy_file);
        if (file_exists($policyFilePath)) {
            unlink($policyFilePath);
        }

        $policy->delete();

        return redirect()->back()->with('success', 'Policy deleted successfully');
    }


}
