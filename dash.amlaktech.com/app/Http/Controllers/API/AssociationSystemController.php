<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssociationSystemResource;
use App\Models\AssociationSystem;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class AssociationSystemController extends Controller
{

    use generateAPI;

    public function __invoke(Request $request)
    {
        $associations = getAllMemberAssociations();

        if ($request->association_id) {
            $associations = [$request->association_id];
        }

        $systemDocument = AssociationSystem::belongsToAssociations($associations)->forUsers()->orderBy('id', 'DESC')->paginate();
        return $this->success(['system_documents' => AssociationSystemResource::collection($systemDocument)]);
    }
}
