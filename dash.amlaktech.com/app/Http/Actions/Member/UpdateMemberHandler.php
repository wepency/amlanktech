<?php

namespace App\Http\Actions\Member;

use App\Models\AssociationsMembers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateMemberHandler
{
    public string $message;

    public function __construct(
        public Request           $request,
        public User $member,
    )
    {
    }

    public function handle()
    {
        $this->member->name = $this->request->name;
        $this->member->email = $this->request->email;
        $this->member->phone_number = $this->request->phone_number;
//        $this->member->address = $this->request->address;
//        $this->member->status = $this->request->status;
        if ($this->request->password != '')
            $this->member->password = Hash::make($this->request->password);
//        $this->member->city_id = $this->request->city_id;

        $this->member->save();

//        AssociationsMembers::where('user_id', $this->member->id)->delete();

        if (is_admin()) {
            foreach ($this->request->association_id as $associationId) {
                AssociationsMembers::updateOrCreate([
                    'association_id' => $associationId,
                    'user_id' => $this->member->id
                ],[
                    'association_id' => $associationId,
                    'user_id' => $this->member->id
                ]);
            }
        }

        $this->message = 'The Member Has Been Updated Successfully';

        return $this;
    }
}
