<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province;

class ProvincesController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => Province::select('name_ar as text', 'id')->active()->get()->toArray()
        ]);
    }
}
