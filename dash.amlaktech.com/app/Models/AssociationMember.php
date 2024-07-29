<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationMember extends User
{
    use HasFactory;

    protected $table = 'users';
}
