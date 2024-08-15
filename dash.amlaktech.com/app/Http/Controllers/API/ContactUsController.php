<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use generateAPI;

    public function __invoke(ContactUsRequest $request)
    {
        return $this->success(['تم استقبال رسالتك وسنتواصل معك في أقرب وقت ممكن.']);
    }
}
