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
Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');


Route::get('/test', function () {
    return view('test');
});

// Front pages
Route::get('/', 'HomeController@index')->name('home');
Route::get('/tentang-kami', 'HomeController@about')->name('tentang-kami');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/layanan', 'HomeController@service')->name('layanan');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/invest', 'AdminController@invest')->name('admin.invest');
    Route::get('/transactions', 'AdminController@transaction')->name('admin.transaction');

    // User prefixed
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'Admin\UserController@index')->name('admin.user');
        Route::get('/table', 'Admin\UserController@table')->name('admin.user.table');
        Route::get('/detail', 'Admin\UserController@detail')->name('admin.user.detail');
        Route::get('/order/updates', 'Admin\UserController@orderUpdates')->name('admin.user.order.updates');
        Route::get('/order/{user}', 'Admin\UserController@order')->name('admin.user.order');
        Route::get('/order/{user}/table', 'Admin\UserController@orderTable')->name('admin.user.order.table');
        Route::get('/balance/{user}/table', 'Admin\BalanceController@table')->name('admin.user.balance.table');
        Route::get('/balance/{user}', 'Admin\BalanceController@index')->name('admin.user.balance');
    });

    // Invest
    Route::group(['prefix' => 'invest'], function () {
        Route::resource('trees', 'Admin\TreeController')->except(['show']);
        Route::get('products/tree/{tree}', 'Admin\ProductController@index')->name('products.index');
        Route::resource('products', 'Admin\ProductController')->except(['show', 'index']);
    });

    // Withdraw
    Route::group(['prefix' => 'withdraw'], function () {
        Route::get('/', 'Admin\WithdrawController@index')->name('admin.withdraw.index');
        Route::get('table', 'Admin\WithdrawController@table')->name('admin.withdraw.table');
        Route::get('change-status', 'Admin\WithdrawController@changeStatus')->name('admin.withdraw.change_status');
    });

    // Order
    Route::group(['prefix' => 'order'], function () {
        Route::get('/table', 'Admin\OrderController@table')->name('admin.order.table');
        Route::get('/', 'Admin\OrderController@index')->name('admin.order.index');
        Route::get("edit/{id}", 'Admin\OrderController@edit')->name('admin.order.edit');
        Route::post("update/{id}", 'Admin\OrderController@update')->name('admin.order.update');
    });

    Route::resource('locations', 'Admin\LocationController');
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
