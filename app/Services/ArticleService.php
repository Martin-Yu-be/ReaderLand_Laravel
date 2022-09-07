<?php

namespace App\Services;

use App\Models\Article;
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
        
        $articles = DB::table('articles as a')
                            ->whereIn('a.id', function($query) use($category, $lastId){
                                $query->select('article_id')
                                    ->from('article_category')
                                    ->where('category_id', '=', function($query) use($category){
                                        $query->select('id')
                                                ->from('categories')
                                                ->where('category', $category);
                                    })
                                    ->where('article_id', '<', $lastId)
                                    ->orderBy('article_id');
                            })
                            ->join('users as u', 'u.id', 'a.user_id')
                            ->orderByDesc('a.id')
                            ->limit(20)
                            ->select(self::$articlesFields)
                            ->get();


        // TODO: fetch articles' category
        $articles->each(function($article){
            $article->categories = Article::find($article->id)->categories()->pluck('category');
        });

        return $articles;
    }
} 