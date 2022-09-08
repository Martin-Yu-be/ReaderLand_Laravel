<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Auth',
    description: 'api for user register and user login',
    version: '1.0'
)]
class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/auth/login',
        tags: ['login'],
        summary: 'user sign in',
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(ref: '#/components/schemas/SignInRequest')
                ),
            ],

        ),
        responses: [ 
                new OA\Response(
                    response: 201, 
                    description:'success',
                    content: [
                        new OA\MediaType(
                            mediaType: 'application/json',
                            schema: new OA\Schema(
                                properties: [
                                    new OA\Property(
                                        property: 'data',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'accessToken', description: 'token', type: 'string', example: 'session-token'),
                                            new OA\Property(property: 'user', type: 'object', ref: "#/components/schemas/UserResource"),
                                        ]
                                    ), 
                                ]
                            ),
                        ),
                    ],
                ),
        ]
    )]
    public function login(AuthUserRequest $request)
    {
        $token = Auth::attempt($request->validated());
        
        if(!$token){
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        
        return response()->json([
            'data' => [
                'user' => new UserResource($user),
                'accessToken' => $token,    
            ]
        ]);
    }

    
    public function register(StoreUserRequest $request, UserService $service)
    {
        $formFields = $request->validated();
        $user = $service->createOne(...$formFields);
        
        
        $token = Auth::login($user);
        
        
        return response()->json([
            'data' => [
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => new UserResource($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ]
        ]);
    }
}
