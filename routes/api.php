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
Route::post('login', 'Api\UserController@login')->name('api.login');

// Register Api
Route::post('register', 'Api\UserController@register')->name('api.register');
    
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
Route::get('cities', 'ApiController@getCities')->name('api.province.cities');
    
// Article Api
Route::get('articles/top', 'Api\ArticleController@getTopArticle')->name('api.articles.top');
Route::get('articles', 'Api\ArticleController@getArticle')->name('api.articles');
Route::post('articles/addview', 'ArticleController@incrementArticleStatistic')->name('api.articles.statistic');
    
// Banner Api
Route::get('banners', 'ApiController@getBanner')->name('api.banners');
    
// Order detail
Route::get('user/orders', 'ApiController@getUserOrderDetail')->name('api.user.order.detail');

// Term And Condition
Route::get('term_and_condition', 'ApiController@getTermAndCondition')->name('api.term_and_condition');

// Routes that use user_key 
// User Api
Route::post('user/details', 'Api\UserController@getUserDetail')->name('api.user.detail');
Route::get('user/banks', 'Api\UserController@getUserBank')->name('api.user.bank');
Route::get('user/orders', 'ApiController@getUserOrder')->name('api.user.order');
Route::post('user/update', 'Api\UserController@updateUserDetail')->name('api.user.update');
Route::post('user/update/id_image', 'Api\UserController@updateUserIdImage')->name('api.user.update.id_image');
Route::post('user/update/image', 'Api\UserController@updateUserImage')->name('api.user.update.image');
Route::post('user/order/product', 'ApiController@orderProduct')->name('api.user.order.product');
Route::post('user/bank/add', 'Api\UserController@userAddBank')->name('api.user.bank.add');