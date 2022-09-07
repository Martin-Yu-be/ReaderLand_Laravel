<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ArticleService $service)
    {
        // TODO: latest, categories
        $category = $request->query('category');
        $lastArticleId = $request->query('lastArticleId') ?? PHP_INT_MAX;

        if($category){
            $articles = $service->getCategoryArticles($category, $lastArticleId);
        } else {
            $articles = $service->getLatestArticles($lastArticleId);
        }

        return response()->json(
            [ "data" => [
                'articles' => new ArticleCollection($articles),
                'endOfFeed' => count($articles) < 20,
        ]]);
    }
}
