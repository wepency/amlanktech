<?php

namespace App\Http\Actions\User;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Admin $user,
    )
    {
    }

    public function handle(): self
    {
        $this->user->name = request()->name;
        $this->user->email = request()->email;
        $this->user->phone_number = request()->phone_number;

        $this->user->association_id = getAssociationId();

        $this->user->address = request()->address;
        $this->user->salary = request()->salary;
        $this->user->password = Hash::make(request()->password);

        $this->user->profession = request()->profession;
//        $this->user->city_id = request()->city_id;

        $this->user->role = 'employee';

        $this->user->save();

        $this->message = 'The User Has Been Updated Successfully';

        $this->user->syncRoles([$this->request->role_group]);

        return $this;
    }

}
