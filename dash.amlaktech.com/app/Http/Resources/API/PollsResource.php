<?php

namespace App\Http\Resources\API;

use App\Models\PollItem;
use App\Models\PollVote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userVotes = PollVote::select('poll_item_id')->where('poll_id', $this->id)->where('user_id', get_auth()->id())->where('user_model', User::class)->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'votes_count' => $this->votes_count,
            'is_answered' => count($userVotes) > 0,
            'selected_option_id' => $userVotes[0]->poll_item_id ?? null,
            'options' => PollItemsResource::collectOptions($this->items, $this->votes_count, $userVotes),
            'created_at' => $this->created_at,
            'voters' => PollVotesResource::make($this->user)
        ];
    }
}
