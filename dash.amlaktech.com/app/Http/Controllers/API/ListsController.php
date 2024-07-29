<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\TicketCategoriesResource;
use App\Http\Resources\API\UnitsResource;
use App\Models\TicketCategory;
use App\Models\Unit;
use App\Traits\generateAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListsController extends Controller
{
    use generateAPI;

    public function units()
    {
        $units = Unit::where('association_member_id', get_auth()->id())
            ->when(filled(request()->association_id), function ($query) {
                return $query->where('association_id', request()->association_id);
            })
            ->orderBy('id', 'DESC')
            ->get();

        return $this->success([
            'units' => UnitsResource::collection($units)
        ]);
    }

    public function ticketCategories()
    {
        $units = TicketCategory::when(filled(request()->association_id), function ($query) {

            return $query->where(function ($query) {

                $associationId = request()->association_id;

                $ticketCategoryCount = DB::table('ticket_categories')
                    ->where('association_id', $associationId)
                    ->count();

                if ($ticketCategoryCount == 0) {
                    return $query;
                } else {
                    // There are ticket categories for this association_id, apply the condition
                    return $query->where('association_id', $associationId);
                }
            });
        })
            ->orderBy('name', 'DESC')
            ->get();

        return $this->success([
            'categories' => TicketCategoriesResource::collection($units)
        ]);
    }
}
