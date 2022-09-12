<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\AuthorSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\ArticleSeeder::class,
        ]);
    }
}
