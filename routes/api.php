<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!

$php artisan route:list
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => "auth:sanctum"],function() {
    Route::apiResources([
        'products'   => 'ProductController',
        'categories' => 'CategoryController'
    ]);
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('newsletter','NewsletterController@send');
    Route::post('products/{product}/rate','ProductRatingController@rate');
    Route::post('products/{product}/unrate','ProductRatingController@unrate');
});

Route::post('sanctum/token','UserTokenController');