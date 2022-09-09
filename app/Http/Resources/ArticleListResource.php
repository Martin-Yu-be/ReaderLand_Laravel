<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'articleId' => $this->id,
            'title' => $this->title,
            'preview' => $this->preview,
            'createdAt' => $this->created_at,
            'readCount' => $this->read_counts, 
            'likeCount' => $this->like_counts, 
            'commentCount' => $this->comment_counts,
            'categories' => array_map(fn($item) => $item['category'], $this->categories->toArray()),
            'author' => [
                'userId' => $this->user->id,
                'name' => $this->user->name,
                'picture' => env('S3_URL').'/avatar/'.$this->user->picture,
                'bio' => $this->user->bio,
                'followed' => false,
            ],
            'liked' => false,
            'favorited' => false,
            'commented' => false,
        ];
    }
}
