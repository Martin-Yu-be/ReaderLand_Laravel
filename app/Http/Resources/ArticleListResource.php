<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ArticleListResource extends JsonResource
{
    #[OA\Schema(
        schema: 'ArticleListResource',
        type:'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: '比時光更寶貴的，原來是陽光！'),
            new OA\Property(property: 'preview', description: 'a short preview of the article', type: 'string'),
            new OA\Property(property: 'createdAt', type: 'datetime', example: '2022-09-06T05:07:37.000000Z'),
            new OA\Property(property: 'readCount', type: 'integer', example: '100'),
            new OA\Property(property: 'likeCount', type: 'integer', example: '65'),
            new OA\Property(property: 'commentCount', type: 'integer', example: '36'),
            new OA\Property(property: 'liked', type: 'bool'),
            new OA\Property(property: 'favorite', type: 'bool'),
            new OA\Property(property: 'commented', type: 'bool'),
            new OA\Property(
                property: 'categories', 
                type: 'array', 
                items: new OA\Items(type: 'string', enum: ['政治與評論', '國際時事', '電影戲劇', '投資理財']),
            ),
            new OA\Property(
                property: 'author', 
                type: 'object',
                properties: [
                    new OA\Property(property: 'userId', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: '釀電影'),
                    new OA\Property(property: 'picture', description: 'Url of the user\'s avatar', type: 'string', example: 'https://reader-land.s3.ap-northeast-1.amazonaws.com/avatar/M觀點.jpg'),
                    new OA\Property(property: 'bio', type: 'string'),
                    new OA\Property(property: 'followed', type: 'bool'),
                ]
            )
        ]
    )]
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
            'liked' => false,
            'favorite' => false,
            'commented' => false,
            'categories' => array_map(fn($item) => $item['category'], $this->categories->toArray()),
            'author' => [
                'userId' => $this->user->id,
                'name' => $this->user->name,
                'picture' => env('S3_URL').'/avatar/'.$this->user->picture,
                'bio' => $this->user->bio,
                'followed' => false,
            ],
        ];
    }
}
