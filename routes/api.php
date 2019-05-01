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

// Authentication process
Route::get('/auth', function (Request $request) {
    return (array) $request->bearerToken();
})->middleware('auth:api');

// Faq Api
Route::get('faq', 'ApiController@getFaq')->name('api.faq');

// Product Api
Route::get('products', 'ApiController@getProduct')->name('api.product');

// Description Api
Route::get('descriptions', 'ApiController@getDescription')->name('api.description');

//Database Status
Route::get('database_status', 'ApiController@databaseStatus')->name('api.database.status');

// Provinces Cities Api
Route::get('provinces', 'ApiController@getProvinces')->name('api.provinces');
Route::get('province/{province}', 'ApiController@getProvinceDetail')->name('api.province.detail');
Route::get('province/{province}/cities', 'ApiController@getCities')->name('api.province.cities');
Route::get('city/{city}', 'ApiController@getCityDetail')->name('api.city.detail');

// Article Api
Route::get('articles/top', 'ApiController@getTopArticle')->name('api.articles.top');
Route::get('articles', 'ApiController@geArticle')->name('api.articles');
Route::get('articles/{id}', 'ApiController@getArticleDetail')->name('api.articles.detail');

/**
 * Route group based on auth:api middleware
 */
Route::group(['middleware' => 'auth:api'], function () {    
    // User Api
    Route::get('user/details', 'ApiController@getUserDetail')->name('api.user.detail');
    Route::get('user/banks', 'ApiController@getUserBank')->name('api.user.bank');
    Route::get('user/orders', 'ApiController@getUserOrder')->name('api.user.order');
    Route::get('user/orders/{token}', 'ApiController@getUserOrderDetail')->name('api.user.order.detail');
});
