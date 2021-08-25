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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


Route::post('registerUser','Auth\RegisterController@store');


Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::get('customers', 'CustomerController@index');
    Route::post('customers/delete','CustomerController@delete');
    Route::get('customers/{id}', 'CustomerController@get');
    Route::post('customers/new', 'CustomerController@store');
    Route::post('customers/edit','CustomerController@editCustomer');
});


Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::post('post/create', 'PostController@create');
    Route::get('questions', 'PostController@index');
    Route::post('post/delete', 'PostController@destroyStatus');
    Route::post('post/respuesta', 'PostController@update');
});
