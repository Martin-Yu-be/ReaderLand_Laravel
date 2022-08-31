<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function store(StoreUserRequest $request){
        $formFields = $request->all();
        $formFields['id'] = fake()->uuid();

        User::create($formFields);
        return $formFields;
    }
}
