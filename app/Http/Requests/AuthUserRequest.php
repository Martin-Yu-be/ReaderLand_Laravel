<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SignInRequest',
    type: 'object', 
    required: [
        'email', 
        'password',
    ],
    properties: [
        new OA\Property(property: 'email', description: 'Veriefied email', type: 'string', example: 'test-user@test.com'),
        new OA\Property(property: 'password', description: 'bcrypted password', type: 'string', example: '$2y$10$Wrs0PCxnnNzO59SMkaTY9.uVhtHwz62D.7czVVUZ8AK7LLZ2p7w0i'),
    ],
)]
class AuthUserRequest extends FormRequest
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



    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
