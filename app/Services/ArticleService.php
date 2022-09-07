<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ArticleService{

    private static $articlesFields = [
        'a.id',
        'a.created_at',
        'a.title',
        'a.preview',
        'a.read_counts',
        'a.like_counts',
        'a.comment_counts',
        'u.name',
        'u.bio',
        'u.picture',
        'u.id as userId',
    ];

    public function getLatestArticles(int $lastId){

        $articles = DB::table('articles as a')
                        ->join('users as u', 'u.id', 'a.user_id')
                        ->where('a.id', '<', $lastId)
                        ->orderBy('a.id', 'DESC')
                        ->select(self::$articlesFields)
                        ->limit(20)
                        ->get();
        
        // TODO: fetch articles' category
        $articles->each(function($article){
            $article->categories = Article::find($article->id)->categories()->pluck('category');
        });

        return $articles;
    }

    public function getCategoryArticles(string $category, int $lastId){ 
        $categoryModel = Category::where('category', $category)->first();

        $articlesId = $categoryModel->articles()
                                    ->where('article_id', '<', $lastId)
                                    ->take(20)
                                    ->pluck('article_id');

        $articles = DB::table('articles as a')
                            ->whereIn('a.id', $articlesId)
                            ->join('users as u', 'u.id', 'a.user_id')
                            ->orderBy('a.id', 'DESC')
                            ->select(self::$articlesFields)
                            ->get();


        // TODO: fetch articles' category
        $articles->each(function($article){
            $article->categories = Article::find($article->id)->categories()->pluck('category');
        });

        return $articles;
    }
} 