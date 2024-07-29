<?php

namespace App\Models;

use App\Traits\ModelPrimaryKeysTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationsMembers extends Model
{
    use HasFactory, ModelPrimaryKeysTrait;

    protected $table = 'associations_users';

//    protected $primaryKey = ['association_id', 'user_id'];

    protected $guarded = [];

    public $timestamps = [];
}
