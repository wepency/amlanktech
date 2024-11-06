<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitCategory extends Model
{
    use HasFactory;

    protected $table = 'permit_categories';

    protected $guarded = ['id'];

    public function permit()
    {
        return $this->hasMany(Permit::class);
    }
}
