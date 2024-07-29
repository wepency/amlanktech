<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {

        $admins = [
            [
                'name' => 'Mahmoud Abukhashaba',
                'email' => 'abukhshba77@gmail.com',
                'password' => Hash::make('123123123'),
                'phone_number' => '01013367402',
                'national_id' => '6776876',
                'role' => 'admin'
            ],
            [
                'name' => 'Ahmed Yasser Salama',
                'email' => 'ahmedyassersalama2014@gmail.com',
                'password' => Hash::make('123123123'),
                'phone_number' => '01013367402',
                'national_id' => '7687878',
                'role' => 'admin'
            ],
            [
                'name' => 'Abbdullah Alghamdi',
                'email' => 'ws6aa@gmail.com',
                'password' => Hash::make('Sed40925!'),
                'phone_number' => '01013367402',
                'national_id' => '878787',
                'role' => 'manager'
            ],
        ];

        foreach ($admins as $admin) {
            Admin::firstOrCreate($admin);
        }
    }
}
