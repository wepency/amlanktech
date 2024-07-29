<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "area" => $this->area,
            "unit_no" => $this->unit_no,
            "association_id" => $this->association_id,
            "fee_type_amount" => $this->fee_type_amount,
            "fee_type_total" => $this->fee_type_total,
            "ownership_type" => $this->ownership_type,
            "ownership_ratio" => $this->ownership_ratio,
            "address" => $this->address,
            "water_meter_serial" => $this->water_meter_serial,
            "electricity_meter_serial" => $this->electricity_meter_serial,
            "created_time" => $this->created_at->diffForHumans(),
            "association" => AssociationsResource::make($this->association),
            "status" => $this->status($this->status),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_formatted' => $this->created_at->format('d M, Y'),
            'updated_at_formatted' => $this->created_at->format('d M, Y'),
        ];
    }


    private function status($status)
    {
        return match ($status) {
            1 => [
                'id' => 1,
                'name' => 'active',
                'color_type' => 'success',
                'text' => 'فعالة',
            ],
            4 => [
                'id' => 4,
                'name' => 'blocked',
                'color_type' => 'danger',
                'text' => 'موقوفة',
            ],
            default => [
                'id' => 0,
                'name' => 'pending',
                'color_type' => 'warning',
                'text' => 'قيد المراجعة',
            ],
        };
    }
}
