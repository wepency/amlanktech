<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitBlock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

}
