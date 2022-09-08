<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/doc', function(){
    // require($_SERVER['DOCUMENT_ROOT']."/../vendor/autoload.php");

    $openapi = \OpenApi\Generator::scan([
        $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Requests/AuthUserRequest.php',
        $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Requests/StoreUserRequest.php',
        $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Resources/UserResource.php',
        $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Controllers/Api/AuthController.php',
    ]);

    header('Content-Type: application/json');
    echo $openapi->toJson();
});