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
// User API    
Route::post('login', 'Api\UserController@login')->name('api.login');
Route::post('register', 'Api\UserController@register')->name('api.register');
Route::post('user/details', 'Api\UserController@getUserDetail')->name('api.user.detail');
Route::post('user/update', 'Api\UserController@updateUserDetail')->name('api.user.update');
Route::post('user/update/id_image', 'Api\UserController@updateUserIdImage')->name('api.user.update.id_image');
Route::post('user/update/image', 'Api\UserController@updateUserImage')->name('api.user.update.image');
Route::post('user/bank/add', 'Api\UserController@userAddBank')->name('api.user.bank.add');

// General API
Route::get('faq', 'Api\GeneralController@getFaq')->name('api.faq');
Route::get('descriptions', 'Api\GeneralController@getDescription')->name('api.description');
Route::get('database_status', 'Api\GeneralController@databaseStatus')->name('api.database.status');
Route::get('provinces', 'Api\GeneralController@getProvinces')->name('api.provinces');
Route::get('cities', 'Api\GeneralController@getCities')->name('api.province.cities');
Route::get('banners', 'Api\GeneralController@getBanner')->name('api.banners');
Route::get('term_and_condition', 'Api\GeneralController@getTermAndCondition')->name('api.term_and_condition');
Route::get('products', 'Api\GeneralController@getProduct')->name('api.product');

// Article Api
Route::get('articles/top', 'Api\ArticleController@getTopArticle')->name('api.articles.top');
Route::get('articles', 'Api\ArticleController@getArticle')->name('api.articles');
Route::post('articles/addview', 'ArticleController@incrementArticleStatistic')->name('api.articles.statistic');

// Order detail
Route::get('user/orders', 'Api\OrderController@getUserOrder')->name('api.user.order');
Route::post('user/order/product', 'Api\OrderController@orderProduct')->name('api.user.order.product');