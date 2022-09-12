<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\ArticleSeeder::class,
            // \Database\Seeders\ArticleCategorySeeder::class
        ]);

        $this->call(\Database\Seeders\ArticleCategorySeeder::class, false, ['categoryId' => 2]);
    }
}
