<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingsResource extends JsonResource
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
            'title' => $this->title,
            'date' => $this->date,
            'description' => 'هذا نص تحريبي',
            'start_time' => $this->start_time,
            'meeting_id' => $this->meeting_id,
            'passcode' => $this->passcode,
            'created_at' => $this->created_at->diffForHumans(),
            'min_users' => $this->min_users,
            'current_users' => 5,
            'is_started' => true
        ];
    }
}
