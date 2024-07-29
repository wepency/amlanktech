<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermitBlock;
use App\Services\PermitBlockService;
use Illuminate\Http\Request;

class PermitBlocksController extends Controller
{
    public function index(Request $request, PermitBlock $permitBlock)
    {
        $permitBlocks = PermitBlock::query();

        if ($request->ajax()) {
            return (new PermitBlockService($permitBlocks))
                ->addColumnNationalId()
                ->addColumnAction()
                ->getAssociationDetails()
                ->setRowId()
                ->toJson();
        }


        return view('Admin.Permits_block.Index', [
            'page_title' => 'قائمة حظر الزوار',
            'permit_blocks' => $permitBlocks
        ]);
    }

    public function create(PermitBlock $permitBlock)
    {
        return response()->json([
            'data' => view('Admin.Permits_block.create', [
                'page_title' => 'اضافة حظر جديد',
                'permit_block' => $permitBlock,
                'url' => dashboard_route('permits.blocklist.store')
            ])->render()
        ]);
    }

    public function store(Request $request, PermitBlock $permitBlock)
    {
        return $this->redirectBack(PermitBlockService::updateOrCreate($request, $permitBlock));
    }

    public function destroy(Request $request, PermitBlock $permitBlock)
    {
        return $this->redirectBack($permitBlock->delete());
    }
}
