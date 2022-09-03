<?php

namespace App\Services;

use App\Models\User;

class UserService 
{
    public static function CreateOne(
        string $name,
        string $email,
        string $password
    ):User { 
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'id' => fake()->uuid(), 
        ]);
    }
}