<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReceiptCategory;
use App\Services\ReceiptCategoryService;
use Illuminate\Http\Request;

class ReceiptCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = ReceiptCategory::query();

        if (is_manager()) {
            $categories = $categories->associationUnits();
        }

        if ($request->ajax()) {
            return (new ReceiptCategoryService($categories))
                ->editColumnId()
                ->addColumnStatus()
                ->addColumnAction()
                ->getAssociationDetails()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();
        }

        return view('Admin.Receipt_category.index', [
            'page_title' => trans('labels.receipts_categories'),
            'categories' => $categories,
            'singleModel' => ReceiptCategoryService::SINGLE_MODEL_TITLE,
            'pluralModel' => ReceiptCategoryService::PLURAL_MODEL_TITLE,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ReceiptCategory $receiptCategory)
    {
        return response()->json([
            'data' => view('Admin.Receipt_category.create', [
                'page_title' => 'اضافة تصنيف سند',
                'url' => dashboard_route('receipt-categories.store'),
                'model' => $receiptCategory
            ])->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ReceiptCategory $receiptCategory)
    {
        try {
            return $this->redirectBack(ReceiptCategoryService::updateOrCreate($request, $receiptCategory));
        }catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack(false);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceiptCategory $receiptCategory)
    {
        return response()->json([
            'data' => view('Admin.Receipt_category.create', [
                'page_title' => 'تعديل التصنيف',
                'url' => dashboard_route('receipt-categories.update', $receiptCategory?->id),
                'model' => $receiptCategory
            ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceiptCategory $receiptCategory)
    {
        try {
            return $this->redirectBack(ReceiptCategoryService::updateOrCreate($request, $receiptCategory));
        }catch (\Exception $exception) {
            report($exception);
            return $this->redirectBack(false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceiptCategory $receiptCategory)
    {
        return $this->redirectBack($receiptCategory->delete());
    }
}
