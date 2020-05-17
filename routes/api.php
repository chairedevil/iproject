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
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', 'Api\LoginController@login')->name('login');
Route::apiResource('/products', 'Api\ProductController', ['only' => ['index']]);

Route::middleware('auth:api')->group(function(){
    Route::get('/mylist', 'Api\UserController@mylist');
    Route::patch('/reserve', 'Api\UserProductListsController@reserve');
    Route::patch('/cancel_reserve', 'Api\UserProductListsController@cancel_reserve');
    Route::patch('/delete_product', 'Api\UserProductListsController@delete_product');
    Route::patch('/done_transaction', 'Api\UserProductListsController@done_transaction');
    Route::patch('/rate_user', 'Api\UserProductListsController@rate_user');
    Route::apiResource('/users', 'Api\UserController');
    Route::apiResource('/products', 'Api\ProductController', ['only' => ['store']]);
    Route::get('/user', function (Request $request) {
        //return $request->user()->only(['id', 'name', 'email', 'ava_path']);
        return response()->json(['data' => $request->user()->only(['id', 'name', 'email', 'ava_path'])], 200);
    });
});

Route::get('/authfailed', function () {
    return response()->json(['msg' => 'Authentication Failed'], 401);
})->name('authFailed');
