<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'preview' => $this->preview ?? '',
            'context' => $this->context ?? '',
            'liked' => false,
            'createdAt' => $this->created_at,
            'readCount' => $this->read_counts, 
            'likeCount' => $this->like_counts, 
            'commentCount' => $this->comment_counts,
            'categories' => $this->categories,
            'author' => [
                'userId' => $this->userId,
                'name' => $this->name,
                'picture' => env('S3_URL').'/avatar/'.$this->picture,
                'bio' => $this->bio,
                'followed' => false,
            ],
            'liked' => false,
            'favorited' => false,
            'commented' => false,
        ];
    }
}
