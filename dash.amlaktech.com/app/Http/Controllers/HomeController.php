<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['associationMember']);
    }

    public function home()
    {
        return view('home');
    }
}
