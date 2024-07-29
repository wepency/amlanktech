<?php

namespace App\Traits;

use App\Models\User;

trait AssociationTrait
{
    private function getMembers()
    {
        $members = User::active()->orderBy('name', 'asc');

        if (!is_admin()) {
            $members = $members->whereHas('association', function ($query){
                return $query->where('id', getAssociationId());
            });
        }

        return $members->get(['id', 'name', 'phone_number']);
    }
}
