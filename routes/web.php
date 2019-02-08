<?php

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
Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');

// Front pages
Route::get('/', 'HomeController@index');
Route::get('/tentang-kami', 'HomeController@about')->name('tentang-kami');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/layanan', 'HomeController@service')->name('layanan');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index');
});

// User routes
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');
    Route::get('/product', 'UserController@product');
    Route::get('/product/order', 'UserController@order');

    // api call
    Route::get('product/api', 'User\OrderController@productApi')->name('user.product.api');
    Route::get('product/api/{status}', 'User\OrderController@productApiStatus')->name('user.product.api.status');
});
