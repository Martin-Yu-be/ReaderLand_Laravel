<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function me(){
        $user = auth()->user();

        if($user){
            return response()->json([
                'data'=> [
                    'user'=> $user,
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'user'=> 'visitor'
                ],
            ]);
        }
    }
}
