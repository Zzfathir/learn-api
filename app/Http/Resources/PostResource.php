<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content'=> $this->news_content,
            'author_id'=> $this->author,
            'comments_total'=> $this->whenLoaded('comments', function() {
                return count($this->comments);
            }),
            'writer'=> $this->writer,
            'created_at'=> $this->created_at,
        ];
    }
}
