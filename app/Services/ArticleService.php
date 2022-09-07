<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleService{

    public function getLatestArticles(int $lastId){

        $articles = DB::table('articles as a')
                        ->join('users as u', 'u.id', 'a.user_id')
                        ->where('a.id', '<', $lastId)
                        ->orderBy('a.id', 'DESC')
                        ->select(
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
                        )
                        ->limit(20)
                        ->get();
        
        // TODO: fetch articles' category
        $articles->each(function($article){
            $article->categories = Article::find($article->id)->categories()->pluck('category');
        });

        return $articles;
    }

    public function getCategoryArticles(string $category, int $lastId = 0){
        // return Article::where(['id', '>', $lastId])->orderBy('id', 'desc')->limit(20)->get()
    }
} 