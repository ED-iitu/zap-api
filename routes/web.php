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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products', 'Admin\ProductController@index')->name('products');
Route::get('/orders', 'Admin\OrderController@index')->name('orders');
Route::get('/users', 'Admin\UserController@index')->name('users');
Route::get('/suppliers', 'Admin\SupplierController@index')->name('suppliers');
