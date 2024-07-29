<?php

namespace Database\Seeders;

use App\Models\SubscriptionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        $types = [
            [
                'name_en'  => 'unit', 'name_ar'  => 'قطعه ',  
            ],

            [
                'name_en'  => 'person', 'name_ar'  => 'فرد',  
            ],

            [
                'name_en'  => 'family', 'name_ar'  => 'عائلة',  
            ],
            [
                'name_en'  => 'car', 'name_ar'  => 'سيارة',  
            ],
           
        ];

        foreach ($types as $type) {
            SubscriptionType::firstOrCreate($type);
        }


    }
}
