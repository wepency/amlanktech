<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function page($slug)
    {
        return view('Frontend.Pages.custom-page', [
            'page_title' => trans('labels.pages.' . $slug)
        ]);
    }
    public function requestSuccess()
    {
        return view('Frontend.Pages.request-success');
    }
}
