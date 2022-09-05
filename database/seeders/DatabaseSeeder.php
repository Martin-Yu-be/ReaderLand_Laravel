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
        \App\Models\User::factory(5)->create();

        $categories = [
            '政治與評論',
            '國際時事',
            '電影戲劇',
            '投資理財',
            '職場產業',
            '閱讀書評',
            '創作',
            'ACG',
            '文化生活',
            '旅行美食',
            '音樂藝文',
            '健康與情感',
            '寵物',
            '個人成長',
            '親子與教育',
            '運動',
            '科學',
            '心理',
        ];
        foreach($categories as $category){
            \App\Models\Category::create([
                'category' => $category
            ]);
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
