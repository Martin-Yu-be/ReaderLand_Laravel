<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['ForceJson'])->group(function(){

    Route::prefix('auth')->group(function(){
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::apiResource('categories', CategoryController::class)
        ->only('index');

    Route::apiResource('articles', ArticleController::class)
        ->only('index');
});


Route::middleware('auth:api')->get('/user/me', function(){
    return response()->json([
        'user' => auth()->user(),
    ]);
});

