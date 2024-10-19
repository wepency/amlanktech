<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];


    public function adminAgreement()
    {
        return $this->belongsToMany(Admin::class, 'companies_admin_agreement')->withPivot('created_at');
    }

    public function adminAgreementPivot()
    {
        return $this->hasMany(CompanyAgreement::class, 'company_id', 'id');
    }
}
