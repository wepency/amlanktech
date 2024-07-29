<?php

namespace App\Services;

use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GiftService
{
    public static function updateOrCreate(Request $request, Gift $gift)
    {
        DB::beginTransaction();

        $associationId = $request->association_id ?? getAssociationId();
        $associationMemberId =  $request->association_member_id;

        $giftData = $request->merge(['association_id' => $associationId])->only('amount', 'association_id', 'association_member_id', 'notes');

        Log::debug($associationMemberId);

        $gift = $gift->updateOrCreate([
            'id' => $gift->id
        ], $giftData);

        if ($gift->wasRecentlyCreated) {
            BudgetService::storeNewBudgetRow([
                'association_id' => $associationId,
                'association_member_id' => $associationMemberId,
                'amount' => $request->amount,
                'type' => 'gift',
                'model_id' => $gift->id,
                'model_type' => Gift::class
            ]);
        }

        DB::commit();
    }
}
