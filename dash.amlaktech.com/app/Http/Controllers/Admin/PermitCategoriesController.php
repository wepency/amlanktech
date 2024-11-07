<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermitCategory;
use App\Services\PermitCategoriesService;
use Illuminate\Http\Request;

class PermitCategoriesController extends Controller
{
    public function index(Request $request, PermitCategory $permitCategory)
    {
        $permitCategory = PermitCategory::withCount('permit');

        if ($request->ajax()) {

            return (new PermitCategoriesService($permitCategory))
                ->editColumnNeedApproval()
                ->addColumnCount()
                ->addColumnActions()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();
        }


        return view('Admin.Permits_category.Index', [
            'page_title' => 'تصنيفات التصاريح',
            'permit_blocks' => $permitCategory
        ]);
    }

    public function create(PermitCategory $permitCategory)
    {
        return response()->json([
            'data' => view('Admin.Permits_category.create', [
                'page_title' => 'اضافة حظر جديد',
                'permitCategory' => $permitCategory,
                'url' => dashboard_route('permit_categories.store')
            ])->render()
        ]);
    }

    public function store(Request $request, PermitCategory $permitCategory)
    {
        return $this->redirectBack(PermitCategoriesService::updateOrCreate($request, $permitCategory));
    }

    public function edit(PermitCategory $permitCategory)
    {
        return response()->json([
            'data' => view('Admin.Permits_Category.create', [
                'page_title' => 'تعديل تصنيف التصريح',
                'permitCategory' => $permitCategory,
                'url' => dashboard_route('permit_categories.store')
            ])->render()
        ]);
    }

    public function update(Request $request, PermitCategory $permitCategory)
    {
        return $this->redirectBack(PermitCategoriesService::updateOrCreate($request, $permitCategory));
    }

    public function destroy(Request $request, PermitCategory $permitCategory)
    {
        return $this->redirectBack($permitCategory->delete());
    }
}
