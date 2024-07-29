<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'link' => route('permits.show', $this->code),
            'association' => [
                'id' => $this?->association?->id,
                'name' => $this?->association?->name,
            ],
            'duration' => $this->permit_days,
            'start_date' => optional($this->start_date)->format('d-m-Y'),
            'login_attempts' => $this->login_attempts,
            'type' => trans('labels.permit.' . $this->type),
            'status' => [
                'name' => $this->status ? 'active' : 'inactive',
                'color_type' => $this->status ? 'success' : 'danger',
                'text' => $this->status ? 'فعال' : 'غير فعال',
                'text_color' => '#ffffff',
                'bg_color' => $this->status ? '#22c03c' : '#ee335e'
            ],
            'visitors' => PermitVisitorsResource::collection($this->visitors),
        ];
    }
}
