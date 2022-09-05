<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
