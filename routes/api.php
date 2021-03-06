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
Route::post('register/firebase', 'Api\UserController@registerFromFirebase')->name('api.register.firebase'); // return result code 13 (belum membuat password)
Route::post('user/details', 'Api\UserController@getUserDetail')->name('api.user.detail');
Route::post('user/update', 'Api\UserController@updateUserDetail')->name('api.user.update');
Route::post('user/update/id_image', 'Api\UserController@updateUserIdImage')->name('api.user.update.id_image');
Route::post('user/update/image', 'Api\UserController@updateUserImage')->name('api.user.update.image');
Route::post('user/verify', 'Api\UserController@resendVerificationEmail')->name('api.user.resend.verification');

// Bank
Route::post('user/bank/add', 'Api\UserController@userAddBank')->name('api.user.bank.add');
Route::post('user/bank/edit', 'Api\UserController@userEditBank')->name('api.user.bank.edit');
Route::post('user/bank/delete', 'Api\UserController@userDeleteBank')->name('api.user.bank.delete');

// Noifications API
Route::get('user/notifications', 'Api\UserController@getNotifications')->name('api.user.notifications');
Route::post('user/notifications/read', 'Api\UserController@markNotificationAsRead')->name('api.user.notifications.read');

// Reset Password API
Route::post('user/edit_password', 'Api\UserController@editPassword')->name('api.user.password.edit');
Route::post('user/create_password', 'Api\UserController@createPassword')->name('api.user.password.create');

// General API
Route::get('faq', 'Api\GeneralController@getFaq')->name('api.faq');
Route::get('descriptions', 'Api\GeneralController@getDescription')->name('api.description');
Route::get('database_status', 'Api\GeneralController@databaseStatus')->name('api.database.status');
Route::get('provinces', 'Api\GeneralController@getProvinces')->name('api.provinces');
Route::get('cities', 'Api\GeneralController@getCities')->name('api.province.cities');
Route::get('banners', 'Api\GeneralController@getBanner')->name('api.banners');
Route::get('term_condition', 'Api\GeneralController@getTermAndCondition')->name('api.term_and_condition');
Route::get('products', 'Api\GeneralController@getProduct')->name('api.product');
Route::get('contacts', 'Api\GeneralController@getContact')->name('api.contact');
Route::get('bank_lists', 'Api\GeneralController@getBankLists')->name('api.bank.list');

// Article Api
Route::get('articles/top', 'Api\ArticleController@getTopArticle')->name('api.articles.top');
Route::get('articles', 'Api\ArticleController@getArticle')->name('api.articles');
Route::post('articles/addview', 'Api\ArticleController@incrementArticleStatistic')->name('api.articles.statistic');

// Order detail
Route::get('user/transactions', 'Api\OrderController@getUserTransactions')->name('api.user.transaction');
Route::get('user/orders', 'Api\OrderController@getUserOrder')->name('api.user.order');
Route::post('user/order/create_transaction', 'Api\OrderController@orderTransaction')->name('api.user.create.transaction');
Route::post('user/order/product', 'Api\OrderController@orderProduct')->name('api.user.order.product');
Route::post('user/order/product_balance', 'Api\OrderController@orderProductByBalance')->name('api.user.order.product');

// User balance
Route::post('user/topup', 'Api\BalanceController@topup')->name('api.user.topup');
Route::post('user/withdraw', 'Api\BalanceController@withdraw')->name('api.user.withdraw');
Route::post('user/topup/list', 'Api\BalanceController@topupList')->name('api.user.topup.list');
Route::post('user/withdraw/list', 'Api\BalanceController@withdrawList')->name('api.user.withdraw.list');

// MidTrans webhook
Route::post('midtrans/webhook', 'Api\GeneralController@midtransWebhook')->name('api.midtrans.webhook');