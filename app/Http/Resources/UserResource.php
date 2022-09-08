<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA; 

class UserResource extends JsonResource
{

    #[OA\Schema(
        schema: 'UserResource',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', description: 'user id', type: 'integer', example: '1'),
            new OA\Property(property: 'name', description: 'user name', type: 'string'),
            new OA\Property(property: 'email', description: 'user verified email', type: 'string', example: 'test@test.com'),
            new OA\Property(property: 'avatar', description: 'user avatar image url', type: 'string'),
            new OA\Property(property: 'updated_at', description: '', type: 'profiled last updated datetime'),
            new OA\Property(property: 'created_at', description: 'account created datetime', type: 'string'),
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => env('S3_URL').'/avatar/'.$this->picture,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
