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


Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::post('/product', 'Api\ProductController@store');
Route::post('/type', 'Api\TypeController@store');
Route::post('/brand', 'Api\BrandController@store');
Route::post('/category', 'Api\CategoryController@store');

Route::get('/product', 'Api\ProductController@index');
Route::get('/product/{id}', 'Api\ProductController@show');
Route::get('/brand/{id}', 'Api\BrandController@show');

Route::patch('/product/{id}', 'Api\ProductController@update');
Route::patch('/brand/{id}', 'Api\BrandController@update');


Route::get('/brand', 'Api\BrandController@index');
Route::get('/category', 'Api\CategoryController@index');
Route::get('/type', 'Api\TypeController@index');

Route::delete('/product', 'Api\ProductController@deleteMany');

Route::post('/thumbnail', 'Api\ProductController@singleImage');
