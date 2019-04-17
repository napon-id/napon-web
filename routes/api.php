<?php

use Illuminate\Http\Request;

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

Route::get('/me', function (Request $request) {
    return (array) $request->bearerToken();
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
    // Faq Api
    Route::get('faq', 'ApiController@getFaq')->name('api.faq');
    
    // User Api
    Route::get('user', 'ApiController@getUser')->name('api.user');
    Route::get('user/details/{user}', 'ApiController@getUserDetail')->name('api.user.detail');
    Route::get('user/orders/{user}', 'ApiController@getUserOrder')->name('api.user.order');
    Route::get('user/balances/{user}', 'ApiController@getUserBalance')->name('api.user.balance');
    Route::get('user/withdraws/{user}', 'ApiController@getUserWithdraw')->name('api.user.withdraw');
    Route::get('user/logs/{user}', 'ApiController@getUserLog')->name('api.user.log');
    
    // Tree Api
    Route::get('tree', 'ApiController@getTree')->name('api.tree');
    
    // Product Api
    Route::get('product', 'ApiController@getProduct')->name('api.product');
    
    // Order Api
    Route::get('order/{order}', 'ApiController@getOrder')->name('api.order');
    Route::get('order/updates/{order}', 'ApiController@getOrderUpdate')->name('api.order.updates');
    
    // Provinces Cities Api
    Route::get('provinces', 'ApiController@getProvinces')->name('api.provinces');
    Route::get('province/{province}', 'ApiController@getProvinceDetail')->name('api.province.detail');
    Route::get('province/{province}/cities', 'ApiController@getCities')->name('api.province.cities');
    Route::get('city/{city}', 'ApiController@getCityDetail')->name('api.city.detail');
});
