<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $city = $this?->city;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'map_link'  => $this->map_link,
            'registration_number' => $this->registration_number,
            'city' => [
                'id' => $city?->id,
                'name' => $city?->name_ar
            ],
            'address' => $this->address,
            'feeType' => $this->feeType?->key != 'amount' ? [
                'id' => $this->feeType?->id,
                'label' => $this->feeType?->identifier,
                'key' => $this->feeType?->key
            ] : null
        ];
    }
}
