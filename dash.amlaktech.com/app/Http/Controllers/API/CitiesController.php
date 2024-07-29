<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function list($province_id = null)
    {
        $cities = City::select('name_ar as text', 'id');

        if (!is_null($province_id))
            $cities = $cities->where('province_id', $province_id);

        return response()->json([
            'data' => $cities->active()->get()
        ]);
    }
}
