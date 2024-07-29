<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;

class PermitsController extends Controller
{
    public function show(string $permit)
    {
        $permit = Permit::where('code', $permit)->firstOrFail();

        return view('Permit', [
            'page_title' => 'تصريح دخول '.$permit->code,
            'permit' => $permit
        ]);
    }
}
