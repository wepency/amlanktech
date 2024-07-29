<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptCategory extends Model
{
    use HasFactory, ModelTrait, SoftDeletes;

    protected $guarded = ['id'];


}
