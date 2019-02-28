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
Route::get('/', 'HomeController@index')->name('home');
Route::get('/tentang-kami', 'HomeController@about')->name('tentang-kami');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/layanan', 'HomeController@service')->name('layanan');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index');
});

// User routes
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'verified']], function () {
    // dashboard
    Route::get('/', 'UserController@index')->name('user.dashboard');

    // user settings
    Route::get('/edit', 'UserController@edit')->name('user.edit');
    Route::post('/edit', 'UserController@editUpdate')->name('user.edit.update');
    Route::get('/edit/password', 'UserController@password')->name('user.password');
    Route::post('/edit/password', 'UserController@passwordUpdate')->name('user.password.update');

    // product routes
    Route::get('/product', 'UserController@product')->name('user.product');
    Route::get('/product/order', 'UserController@order')->name('user.product.order');
    Route::post('/product/order', 'User\OrderController@order');
    Route::get('/product/checkout/{token}', 'User\OrderController@checkout')->name('user.product.checkout');
    Route::get('/activity', 'UserController@activity')->name('user.activity');
    Route::get('/product/detail/{token}', 'User\OrderController@detail')->name('user.product.detail');
    Route::get('/product/detail/{token}/{id}', 'User\OrderController@update')->name('user.product.update');

    // Wallet routes
    Route::get('/wallet', 'User\WalletController@index')->name('user.wallet');
    Route::get('/wallet/withdraw', 'User\WalletController@withdraw')->name('user.wallet.withdraw');
    Route::post('/wallet/withdraw', 'User\WalletController@withdrawStore')->name('user.wallet.withdraw.store');
    Route::get('/wallet/add', 'User\WalletController@create')->name('user.wallet.add');
    Route::post('/wallet/add', 'User\WalletController@store');
    Route::delete('/wallet/{id}', 'User\WalletController@destroy');

    // api call
    Route::get('product/api', 'User\OrderController@productApi')->name('user.product.api');
    Route::get('product/api/order', 'User\OrderController@productApiOrder')->name('user.product.api.order');
    Route::get('product/api/{status}', 'User\OrderController@productApiStatus')->name('user.product.api.status');
});
