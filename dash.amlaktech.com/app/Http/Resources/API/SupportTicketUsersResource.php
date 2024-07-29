<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {

        return array_merge([
            'user' => $this->sender->name,
            'id' => $this->id,
            'type' => $this->sender_type,
        ], $this->senderDetails());
    }

    private function senderDetails()
    {
        return [
            'name' => $this?->sender->name,
            'avatar' => asset('assets/images/user.png'),
            'role' => $this->sender_type == 'member' ? 'صاحب الطلب' : 'إدارة الجمعية'
        ];
    }
}
