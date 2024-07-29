<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketMessagesResource extends JsonResource
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
            'user' => SupportTicketUsersResource::make($this),
            'body' => $this->body,
            'attachments' => TicketAttachmentsResource::collection($this->attachments),
            'stars' => $this->stars
        ];
    }
}
