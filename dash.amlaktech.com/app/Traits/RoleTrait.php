<?php

namespace App\Traits;

use App\Models\Role;

trait RoleTrait
{
    public function getRole()
    {
        $roles = Role::query();
        $request = request();

        if ($request->association_id) {
            $roles = $roles->where('association_id', $request->association_id)->orWhereNull('association_id');
        }

        return $roles->get();
    }
}
