<?php

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
    
// Login Api
Route::post('login', 'ApiController@login')->name('api.login');

// Register Api
Route::post('register', 'ApiController@register')->name('api.register');
    
// Faq Api
Route::get('faq', 'ApiController@getFaq')->name('api.faq');
    
// Product Api
Route::get('products', 'ApiController@getProduct')->name('api.product');
    
// Description Api
Route::get('descriptions', 'ApiController@getDescription')->name('api.description');
    
// Database Status
Route::get('database_status', 'ApiController@databaseStatus')->name('api.database.status');
    
// Provinces Cities Api
Route::get('provinces', 'ApiController@getProvinces')->name('api.provinces');
Route::get('province/{province}', 'ApiController@getProvinceDetail')->name('api.province.detail');
Route::get('province/{province}/cities', 'ApiController@getCities')->name('api.province.cities');
Route::get('city/{city}', 'ApiController@getCityDetail')->name('api.city.detail');
    
// Article Api
Route::get('articles/top', 'ApiController@getTopArticle')->name('api.articles.top');
Route::get('articles', 'ApiController@getArticle')->name('api.articles');
Route::post('articles/addview', 'ApiController@incrementArticleStatistic')->name('api.articles.statistic');
    
// Banner Api
Route::get('banners', 'ApiController@getBanner')->name('api.banners');
    
// Order detail
Route::get('user/orders', 'ApiController@getUserOrderDetail')->name('api.user.order.detail');

// Routes that use user_key 
// User Api
Route::post('user/details', 'ApiController@getUserDetail')->name('api.user.detail');
Route::get('user/banks', 'ApiController@getUserBank')->name('api.user.bank');
Route::get('user/orders', 'ApiController@getUserOrder')->name('api.user.order');
Route::post('user/update', 'ApiController@updateUserDetail')->name('api.user.update');
Route::post('user/order/product', 'ApiController@orderProduct')->name('api.user.order.product');
Route::post('user/bank/add', 'ApiController@userAddBank')->name('api.user.bank.add');