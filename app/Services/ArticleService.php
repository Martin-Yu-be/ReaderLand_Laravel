<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleService{

    private static $articlesFields = [
        'id',
        'user_id', 
        'created_at', 
        'title', 
        'preview', 
        'read_counts', 
        'like_counts', 
        'comment_counts'
    ];

    public function getLatestArticles(int $lastArticleId){

        return Article::select(self::$articlesFields)
                                ->where('id', '<', $lastArticleId)
                                ->with('user')
                                ->with('categories')
                                ->orderByDESC('id')
                                ->limit(20)
                                ->get();

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