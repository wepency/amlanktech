<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use App\Services\TicketCategoryService;
use Illuminate\Http\Request;

class TicketCategoriesController extends Controller
{
    public function index(Request $request, TicketCategory $ticketCategory)
    {

        $ticketCategories = getOnlyObjectsAccordingToAdmin($ticketCategory, 'association_id')->with('association');

        if ($request->ajax()) {
            return (new TicketCategoryService($ticketCategories))
                ->editColumnId()
                ->addColumnStatus()
                ->addColumnAction()
                ->getAssociationDetails()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();
        }

        return view('Admin.TicketCategories.index', [
            'page_title' => trans('labels.tickets_categories'),
            'categories' => $ticketCategories,
            'singleModel' => TicketCategoryService::SINGLE_MODEL_TITLE,
            'pluralModel' => TicketCategoryService::PLURAL_MODEL_TITLE,
        ]);
    }

    public function create(TicketCategory $ticketCategory)
    {
        return response()->json([
            'data' => view('Admin.TicketCategories.create', [
                'page_title' => 'اضافة تصنيف للطلبات',
                'url' => dashboard_route('ticket-categories.store'),
                'model' => $ticketCategory
            ])->render()
        ]);
    }

    public function edit($ticketCategories)
    {
        $ticketCategory = TicketCategory::findOrFail($ticketCategories);

        return response()->json([
            'data' => view('Admin.TicketCategories.create', [
                'page_title' => 'تعديل التصنيف',
                'url' => dashboard_route('ticket-categories.update', $ticketCategories?->id),
                'model' => $ticketCategories
            ])->render()
        ]);
    }

    public function store(TicketCategory $ticketCategory)
    {

        $create = $ticketCategory->create(request()->all() + [
            'association_id' => getAssociationId()
        ]);

        return $this->redirectBack(
            $create
        );
    }
}
