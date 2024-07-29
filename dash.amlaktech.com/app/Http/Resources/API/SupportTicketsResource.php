<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketsResource extends JsonResource
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
            'code' => '#'.$this->code,
            'title' => $this->title,
            'content' => SupportTicketContentResource::make($this->firstMessage),
            'association' => AssociationsResource::make($this->association),
            'can_apply_appeal' => canApplyAppeal($this->lastMessage),
            'category' => SupportTicketCategoriesResource::make($this->category),
            'status' => $this->status(),
            'created_at' => $this->created_at,
            'replies' => $this->when($this->resource->show_details, function (){
                return SupportTicketMessagesResource::collection($this->ticketMessages()->orderBy('id', 'DESC')->get());
            })
        ];
    }

    private function status()
    {
        return match ($this->status) {
            'notSolved' => [
                'id' => 0,
                'name' => $this->status,
                'color_type' => 'secondary',
                'bg_color' => '#737f9e',
                'text' => trans('labels.tickets_status.'.$this->status),
            ],
            'solved' => [
                'id' => 2,
                'name' => $this->status,
                'color_type' => 'success',
                'bg_color' => '#22c03c',
                'text' => trans('labels.tickets_status.'.$this->status),
            ],
            'closed', checkIfTicketExpired($this->lastMessage) => [
                'id' => 1,
                'name' => 'pending',
                'color_type' => 'warning',
                'bg_color' => '#fbbc0b',
                'text' => trans('labels.tickets_status.'.$this->status),
            ],
            default => [
                'id' => 3,
                'name' => $this->status,
                'color_type' => 'danger',
                'bg_color' => '#ee335e',
                'text' => trans('labels.tickets_status.'.$this->status),
            ],
        };
    }
}
