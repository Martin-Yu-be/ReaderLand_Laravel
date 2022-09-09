<?php

namespace App\Http\Controllers\Api;

use App\Services\ArticleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetArticlesRequest;
use App\Http\Resources\ArticleListResource;
use OpenApi\Attributes as OA;

class ArticleController extends Controller
{
    #[OA\Get(
        path: '/api/articles',
        tags: ['articles'],
        summary: 'Fetch latest or category articles',
        parameters:[
            new OA\Parameter(name: 'lastArticleId', description: 'id of last article in previous fetch', in: 'query', required: false, example: 1),
            new OA\Parameter(name: 'category', description: 'category of the article', in: 'query', required: false, example: 'ACG'),
        ], 
        responses:[
            new OA\Response(
                response: 200,
                description: 'success', 
                content: [
                    new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            properties: [
                                new OA\Property(
                                    property: 'data',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/ArticleListResource'),
                                )
                            ]
                        )
                    )
                ]
            )
        ]
    )]
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

        return ArticleListResource::collection($articles)
                ->response()
                ->setStatusCode(200);
    }
}
