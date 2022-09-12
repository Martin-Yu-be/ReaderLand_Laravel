<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[
    OA\Info(
    title: 'ReaderLand_Laravel',
    description: 'api doc for ReaderLand_Laravel Project',
    version: '1.0',
    ),
    OA\Tag(
        name: 'articles',
        description: 'Everything about api for articles' 
    ),
]
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
