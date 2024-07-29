<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\SystemDocumentsResource;
use App\Models\SystemDocument;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class SystemDocumentController extends Controller
{
    use generateAPI;

    public function __invoke(Request $request)
    {
        $associations = getAllMemberAssociations();

        if ($request->association_id) {
            $associations = [$request->association_id];
        }

        $systemDocument = SystemDocument::belongsToAssociations($associations)->forUsers()->orderBy('id', 'DESC')->paginate();
        return $this->success(['system_documents' => SystemDocumentsResource::collection($systemDocument)]);
    }
}
