<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userCount = max((int) $this->command->ask('How many user would you like?', 90), 1);
        \App\Models\User::factory($userCount)->create();
    }
}
