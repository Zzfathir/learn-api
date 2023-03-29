<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPostResource extends JsonResource
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
            'image' => $this->image,
            'news_content'=> $this->news_content,
            'author_id'=> $this->author,
            'created_at'=> $this->created_at,
            'writer'=> $this->whenLoaded('writer'),
            'comments_total'=> $this->whenLoaded('comments', function() {
                return count($this->comments);
            }),
            'comments'=> $this->whenLoaded('comments', function() {
                return collect($this->comments)->each(function($comment) {
                    $comment->commentator;
                    return $comment;
                });
            }),
        ];
    }
}
