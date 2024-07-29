<?php

namespace App\Interfaces;

use App\Models\Association;
use Illuminate\Http\Request;

interface AssociationInterface
{
    public static function CreateOrUpdate(Request $request, Association $association);
}
