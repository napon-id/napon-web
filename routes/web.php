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
Route::get('/verified', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('images/user/{filename}', function ($filename) {
$path = storage_path('app/public/user/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('images/blog/{filename}', function ($filename) {
    $path = storage_path('app/public/blog/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

// Front pages
Route::get('/', 'HomeController@index')->name('home');
Route::get('/tentang-kami', 'HomeController@about')->name('tentang-kami');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/layanan', 'HomeController@service')->name('layanan');

// Blog pages
Route::get('/blog', 'BlogController@index')->name('blog.index');
Route::get('/blog/{title}', 'BlogController@show')->name('blog.show');

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
        // order updates
        Route::get('{order}', 'Admin\OrderUpdateController@index')->name('admin.order.update.index');
        Route::get('{order}/create', 'Admin\OrderUpdateController@create')->name('admin.order.update.create');
        Route::post('{order}/create', 'Admin\OrderUpdateController@store')->name('admin.order.update.store');
        Route::get('{order}/{id}/edit', 'Admin\OrderUpdateController@edit')->name('admin.order.update.edit');
        Route::put('{order}/{id}/edit', 'Admin\OrderUpdateController@update')->name('admin.order.update.update');
        Route::delete('{order}/{id}', 'Admin\OrderUpdateController@destroy')->name('admin.order.update.destroy');
    });

    Route::resource('locations', 'Admin\LocationController');

    // Blog
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/table', 'Admin\BlogController@table')->name('admin.blog.table');
        Route::get('/', 'Admin\BlogController@index')->name('admin.blog.index');
        Route::get('/create', 'Admin\BlogController@create')->name('admin.blog.create');
        Route::post('/create', 'Admin\BlogController@store')->name('admin.blog.store');
        Route::get('{id}', 'Admin\BlogController@show')->name('admin.blog.show');
        Route::put('{id}/edit', 'Admin\BlogController@update')->name('admin.blog.update');
        Route::get('{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
        Route::delete('{id}', 'Admin\BlogController@destroy')->name('admin.blog.destroy');
    });

    Route::get('term_and_condition', 'Admin\SettingController@termAndCondition')->name('admin.term_and_condition');
    Route::post('term_and_condition', 'Admin\SettingController@termAndConditionUpdate')->name('admin.term_and_condition.update');
    Route::get('contact', 'Admin\SettingController@contact')->name('admin.contact');
    Route::post('contact', 'Admin\SettingController@contactUpdate')->name('admin.contact.update');
});