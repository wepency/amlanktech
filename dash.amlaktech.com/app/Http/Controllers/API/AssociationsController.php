<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AssociationsResource;
use App\Http\Resources\API\UnitsResource;
use App\Models\Association;
use App\Models\Unit;
use App\Traits\generateAPI;

class AssociationsController extends Controller
{
    use generateAPI;

    public function index()
    {
        $associations = Association::with('city')->orderBy('name', 'ASC')->get();

        return $this->success([
            'associations' => AssociationsResource::collection($associations),
        ]);
    }
}
