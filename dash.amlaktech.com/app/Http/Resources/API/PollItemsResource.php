<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollItemsResource extends JsonResource
{
    public static $totalVotes = 0;
    public static $userVotes = [];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $votes = [];
        $optionVotesCount = count($this->votes);
        $totalVotes = max(self::$totalVotes, 1);

        foreach ($this->votes as $vote) {
            $votes[] = UserResource::make($vote->user);
        }

        return [
            'id' => $this->id,
            'name' => $this->title,
            'votes_count' => count($this->votes),
            'vote_percent' => ($optionVotesCount / $totalVotes) * 100,
            'is_selected' => is_array(self::$userVotes) && in_array($this->id, self::$userVotes),
            'votes' => $votes,
        ];
    }

    public static function collectOptions($items, $totalVotes, $userVotes = [])
    {
        self::$totalVotes = $totalVotes;

        if (count($userVotes) > 0) {
            $userVotes = $userVotes->pluck('poll_item_id')->toArray();
        }

        self::$userVotes = $userVotes;

        return parent::collection($items);
    }
}
