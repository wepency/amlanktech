<?php

namespace App\Interfaces;

use App\Models\Admin;
use Illuminate\Http\Request;

interface AdminInterface
{
    public static function CreateOrUpdate(Request $request, Admin $admin);
}
