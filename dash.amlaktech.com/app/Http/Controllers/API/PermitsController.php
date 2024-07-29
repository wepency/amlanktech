<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StorePermitsRequest;
use App\Http\Requests\API\UpdatePermitsRequest;
use App\Http\Resources\PermitsResource;
use App\Models\Permit;
use App\Services\PermitService;
use App\Traits\generateAPI;

class PermitsController extends Controller
{
    use generateAPI;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permits = get_auth()->user()->permits()->latest()->get();

        return $this->success([
            'permits' => PermitsResource::collection($permits)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermitsRequest $request, Permit $permit)
    {
        $request->merge([
            'member_id' => get_auth()->id()
        ]);

        if(PermitService::updateOrCreate($request, $permit))
            return $this->success(['تم انشاء التصريح بنجاح.']);

        return $this->error(['رقم الهويه محظور يرجى مراجعه رئيس / مدير الجمعيه.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $permit)
    {
        $permit = Permit::where('code', $permit)->firstOrFail();

        return $this->success([
            'permit_link' => route('permits.show', $permit->code),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermitsRequest $request, Permit $permit)
    {
        $request->merge([
            'member_id' => get_auth()->id()
        ]);

        if(PermitService::updateOrCreate($request, $permit))
            return $this->success(['تم تعديل التصريح بنجاح.']);

        return $this->error(['رقم الهويه محظور يرجى مراجعه رئيس / مدير الجمعيه.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permit $permit)
    {
        if($permit->delete())
            return $this->success(['تم الحذف بنجاح.']);

        return $this->error(['هناك مشكلة في حذف التصريح.']);
    }
}
