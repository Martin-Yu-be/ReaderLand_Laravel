<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    #[OA\Schema(
        schema: 'StoreUserRequest',
        type: 'object',
        required: [
            'name', 
            'email',
            'password', 
            'password_confirmation',
        ], 
        properties: [
            new OA\Property(property: '', description: 'user name', type: 'string'),
            new OA\Property(property: 'email', description: 'Verified email', type: 'string', example: 'test-user@test.com'),
            new OA\Property(property: 'password', description: 'string password', type: 'string', example: 'password12345678'),
            new OA\Property(property: 'password_confirmation', description: 'repeated password for confirmation', type: 'string'),
        ]
    )]
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
