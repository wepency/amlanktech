<?php

namespace App\Interfaces;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

interface UserInterface
{
    public static function CreateOrUpdate(Request $request, Authenticatable $association);
}
