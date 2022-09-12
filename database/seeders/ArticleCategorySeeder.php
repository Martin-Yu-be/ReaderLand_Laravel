<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleCategorySeeder extends Seeder
{
    public function run($categoryId=1)
    {
        $categories = Category::all(['id'])->toArray();
        $categoryIdArr = array_map(fn($category) => $category['id'], $categories);

        Article::all(['id'])->each(function(Article $article) use($categoryIdArr, $categoryId){
            $randIdKey = array_rand($categoryIdArr, 2);
            $randId = array_map(fn($key)=> $categoryIdArr[$key], $randIdKey);

            if(!in_array($categoryId, $randId)){
                $randId = array_push($randId, $categoryId);
            }

            $article->categories()->attach($randId);
        });
    }
}
