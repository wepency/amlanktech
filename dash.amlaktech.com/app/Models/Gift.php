<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Interfaces\BudgetModelsInterface;

class Gift extends Model implements BudgetModelsInterface
{
    use HasFactory, ModelTrait;

    protected $guarded = ['id'];

    public function getTitle()
    {
        return trans('labels.gift');
    }

    public function associationMember(): BelongsTo
    {
        return $this->belongsTo(AssociationMember::class);
    }
}
