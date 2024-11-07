<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAgreement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'companies_admin_agreement';

    public function company()
    {
        return $this->belongsTo(company::class, 'company_id');
    }
}
