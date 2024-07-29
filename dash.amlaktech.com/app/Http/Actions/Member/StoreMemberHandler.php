<?php

namespace App\Http\Actions\Member;

use App\Models\User;
use App\Models\AssociationsMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StoreMemberHandler
{
    public function __construct(
        public Request $request
    )
    {
    }

    public function handle(): User
    {
        DB::beginTransaction();

        $member = new User;

//        $member->association_id = $this->request->get('association_id');

        $member->name = $this->request->get('name');
        $member->email = $this->request->get('email');
        $member->phone_number = $this->request->get('phone_number');

        $member->password = Hash::make($this->request->get('password'));

        $member->fee_type_amount = $this->request->get('fee_type_amount');
        $member->status = 1;

        $member->save();

        if (is_admin()) {
            foreach ($this->request->association_id as $associationId) {
                AssociationsMembers::updateOrCreate([
                    'association_id' => $associationId,
                    'user_id' => $member->id
                ],[
                    'association_id' => $associationId,
                    'user_id' => $member->id
                ]);
            }
        }

        DB::commit();

        return $member;
    }
}
