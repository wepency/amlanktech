<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id',
        'visitor_name',
        'national_id',
    ];

    public $timestamps = [];
}
