<?php

namespace App\Services;

use App\Models\Article;

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

    public function getCategoryArticles(string $category, int $lastArticleId){ 

        return Article::select(self::$articlesFields)
                            ->whereIn('id', function($query) use($category){
                                $query->select('article_id')
                                        ->from('article_category')
                                        ->where('category_id', function($query) use($category){
                                            $query->select('id')
                                                ->from('categories')
                                                ->where('category', $category);
                                       });         
                            })
                            ->where('id', '<', $lastArticleId)
                            ->with('user')
                            ->with('categories')
                            ->orderByDESC('id')
                            ->limit(20)
                            ->get();
    }
} 