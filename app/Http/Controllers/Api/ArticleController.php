<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetArticlesRequest;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetArticlesRequest $request, ArticleService $service)
    {
        // TODO: query params: lastArticleId, category
        $validatedFields = $request->validated();
        $lastArticleId = isset($validatedFields['lastArticleId']) ? $validatedFields['lastArticleId'] : PHP_INT_MAX;

        if(isset($validatedFields['category'])){
            $articles = $service->getCategoryArticles($validatedFields['category'], $lastArticleId ?? PHP_INT_MAX);
        } else {
            $articles = $service->getLatestArticles($lastArticleId);
        }

        return response()->json(
            [ "data" => [
                'articles' => new ArticleCollection($articles),
                // 'articles' => $articles,
                'endOfFeed' => count($articles) < 20,
        ]]);
    }
}
