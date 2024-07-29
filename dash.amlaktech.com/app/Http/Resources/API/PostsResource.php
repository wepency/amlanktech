<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    private static array $reactions = [];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => get_image_path('posts', $this->image),
            'images' => [
                get_image_path('posts', $this->image),
                get_image_path('posts', $this->image),
                get_image_path('posts', $this->image),
            ],
            'content' => $this->content,
            'since' => $this->created_at->diffForHumans(now()),
            'likes' => $this->likes ?? 0,
            'dislikes' => $this->dislikes ?? 0,
            'my_reaction' => array_key_exists($this->id, self::$reactions) ? getReactionString(self::$reactions[$this->id]) : '',
            'comments' => PostCommentsResource::collection($this->comments)
        ];
    }

    public static function makeCollection($posts, $reactions = [])
    {
        self::$reactions = $reactions;
        return parent::collection($posts);
    }
}
