<?php

namespace App\Http\Requests\Member;

use App\Models\AssociationMember;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{



    public function authorize(): bool
    {
        return true;
    }


    public function rules(AssociationMember $member): array
    {
        return [
            'name'          => 'required',
            'phone_number'  => 'required|numeric',
            'association_id'=>'required',
//            'address'       =>'nullable',
            'status'        =>'nullable',
//            'city_id'       =>'nullable',

        ];

        if ($this->input('email') !== $member->email) {

            $rules['email'] = 'required|email|unique:association_members,email';
        } else {

            $rules['email'] = 'required|email';
        }

        if ($this->filled('password_confirmation')) {
            $rules['password'] = 'required|confirmed|min:8';
        }

    }
}
