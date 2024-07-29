<?php

namespace App\Http\Actions\User;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreUserHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Admin
    {
        $User = new Admin;

        $User->name= $this->request->get('name');
        $User->email = $this->request->get('email');
        $User->phone_number = $this->request->get('phone_number');

        $User->association_id = getAssociationId();

        $User->profession = $this->request->get('profession');
        $User->salary = $this->request->get('salary');
        $User->password = Hash::make($this->request->get('password'));

        $User->role = 'employee';

        $User->save();

        $User->syncRoles([$this->request->role_group]);

        return $User;
    }
}
