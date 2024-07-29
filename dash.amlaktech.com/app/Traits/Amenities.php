<?php

namespace App\Traits;

trait Amenities
{
    protected array $counts_arr = [
        'rooms' => [
            'bedrooms',
            'single_beds',
            'master_beds',
        ],
        'receptions' => [
            'receptions',
            'main_reception',
            'additional_reception',
            'external_reception',
            'external_extension'
        ],
        'toilets' => [
            'toilets'
        ],
        'kitchens' => [
            'kitchens',
            'table_seats'
        ],
        'pools' => [
            'pools'
        ]
    ];
}
