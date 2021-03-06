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

Route::middleware('basicAuth')->prefix('v1')->namespace('API\v1')->group(function (): void {
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/verify', 'AuthController@verify');
    Route::post('user/garage', 'UserController@garage');
    Route::get('category', 'CategoryController@categories');
    Route::get('search', 'SearchController@search');
    Route::get('part/{id}', 'PartController@getOne');
    Route::get('parts', 'PartController@getMany');

    Route::get('user/get-garage/{vin}', 'UserController@getGarage');
    Route::get('suppliers', 'UserController@getSuppliers');
    Route::get('supplier/{id}', 'UserController@getOneSupplier');
});

Route::middleware('auth:sanctum')->prefix('v1')->namespace('API\v1')->group(function (): void {
    Route::get('user/garage/{vin}', 'UserController@getGarage');
    Route::delete('user/garage/{vin}', 'UserController@deleteGarage');

    Route::post('user/garage', 'UserController@garage');

    Route::get('user/profile', 'UserController@profile');
    Route::post('user/profile', 'UserController@changeProfile');

    Route::post('user/change-phone', 'UserController@changePhone');

    Route::get('user/address', 'UserController@getAddress');
    Route::post('user/address', 'UserController@addAddress');
    Route::delete('user/address/{id}','UserController@deleteAddress');
    Route::get('user/garages', 'UserController@getAllGarages');

    Route::post('order', 'OrderController@create');
    Route::get('orders', 'OrderController@getAll');
    Route::get('order/{id}', 'OrderController@getOne');

    Route::post('feedback', 'FeedbackController@createFeedback');
});

