<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public $timestamps = ['updated_at'];
    protected $fillable = [
        'filename',
        'path',
        'model_id',
        'model_type',
        'filetype'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
