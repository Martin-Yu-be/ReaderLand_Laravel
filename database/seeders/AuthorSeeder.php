<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        // seed author info
        $json = file_get_contents(__DIR__.'/testcase.json');
        ["authors" => $authors] = json_decode($json, true);

        foreach($authors as $key => $author)
        {
            User::create([
                'email' => 'author_'.$key.'@ReaderLand.com',
                'password' => bcrypt('password'),
                ...$author
            ]);
        }
    }
}
