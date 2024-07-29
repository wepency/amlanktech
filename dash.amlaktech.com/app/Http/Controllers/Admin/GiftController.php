<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gift\StoreGiftRequest;
use App\Http\Requests\Gift\UpdateGiftRequest;
use App\Models\Association;
use App\Models\User;
use App\Models\Gift;
use App\Services\GiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GiftController extends Controller
{

    public function index()
    {
        $gifts = Gift::with('association');

        if (!is_admin()) {
            $gifts = $gifts->where('association_id', getAssociationId());
        }

        $gifts = $gifts->orderBy('id', 'DESC')->paginate(PAGINATION_LENGTH);

        return view('Admin.Gifts.Index', [
            'page_title' => 'الهبات',
            'gifts' => $gifts
        ]);
    }

    public function create(Gift $gift)
    {
        return response()->json([
            'data' => view('Admin.Gifts.create', [
                'page_title' => 'إضافة هبة جديدة',
                'gift' => $gift,
                'members' => $this->getAssociationMembers(),
                'url' => route('dashboard.gifts.store')
            ])->render()
        ]);
    }

    public function store(StoreGiftRequest $request, Gift $gift)
    {
        try {

            GiftService::updateOrCreate($request, $gift);
            return back()->withSuccess('Association created successfully');

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
        }

        return back()->withError('There was an error creating this gift.');
    }


    public function edit(Gift $gift)
    {
        return response()->json([
            'data' => view('Admin.Gifts.create', [
                'gift' => $gift,
                'members' => $this->getAssociationMembers(),
                'url' => route('dashboard.gifts.update', $gift->id)
            ])->render()
        ]);
    }

    public function update(UpdateGiftRequest $request, Gift $gift)
    {
        try {

            GiftService::updateOrCreate($request, $gift);
            return back()->withSuccess('Association created successfully');

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }

        return back()->withError('There was an error creating this gift.');
    }


    public function destroy($id)
    {
        $gift = Gift::findOrFail($id);


        $gift->delete();

        return redirect()->back()->with('success', 'Gift deleted successfully');
    }

    private function getAssociationMembers()
    {
        return User::select('name', 'id')->orderBy('name', 'asc')->get();
    }
}
