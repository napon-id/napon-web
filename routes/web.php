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

Route::get('report/{filename}', function ($filename) {
    $path = storage_path('app/public/report/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('banner/{filename}', function ($filename) {
    $path = storage_path('app/public/banner/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('description/{filename}', function ($filename) {
    $path = storage_path('app/public/description/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('certificate/{filename}', function ($filename) {
    $path = storage_path('app/public/certificate/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('product/{filename}', function ($filename) {
    $path = storage_path('app/public/product/' . $filename);

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
        Route::delete('/delete/{user}', 'Admin\UserController@destroy')->name('admin.user.destroy');
        Route::get('/detail/{user}', 'Admin\UserController@detail')->name('admin.user.detail');
        Route::get('/order/updates', 'Admin\UserController@orderUpdates')->name('admin.user.order.updates');
        Route::get('/notification/{user}', 'Admin\UserController@notification')->name('admin.user.notification');

        // order
        Route::get('/order/{user}', 'Admin\UserController@order')->name('admin.user.order');
        Route::get('/order/{user}/edit/{order}', 'Admin\OrderController@orderEdit')->name('admin.user.order.edit');
        Route::put('/order/{user}/edit/{order}', 'Admin\OrderController@orderUpdate')->name('admin.user.order.update');
        Route::get('/order/{user}/report/{order}', 'Admin\OrderController@report')->name('admin.user.order.report');
        Route::get('/order/{user}/report/{order}/create', 'Admin\OrderController@reportCreate')->name('admin.user.order.report.create');
        Route::post('/order/{user}/report/{order}/create', 'Admin\OrderController@reportStore')->name('admin.user.order.report.store');
        Route::get('/order/{user}/report/{order}/edit/{report}', 'Admin\OrderController@reportEdit')->name('admin.user.order.report.edit');
        Route::put('/order/{user}/report/{order}/edit/{report}', 'Admin\OrderController@reportUpdate')->name('admin.user.order.report.update');
        Route::delete('/order/{user}/report/{order}/delete/{report}', 'Admin\OrderController@reportDestroy')->name('admin.user.order.report.destroy');

        // location
        Route::get('/order/{user}/location/{order}', 'Admin\LocationController@index')->name('admin.user.order.location');
        Route::get('/order/{user}/location/{order}/create', 'Admin\LocationController@create')->name('admin.user.order.location.create');
        Route::post('/order/{user}/location/{order}/store', 'Admin\LocationController@store')->name('admin.user.order.location.store');
        Route::get('/order/{user}/location/{order}/edit/{location}', 'Admin\LocationController@edit')->name('admin.user.order.location.edit');
        Route::put('/order/{user}/location/{order}/edit/{location}', 'Admin\LocationController@update')->name('admin.user.order.location.update');
        Route::delete('/order/{user}/location/{order}/delete/{location}', 'Admin\LocationController@destroy')->name('admin.user.order.location.destroy');
        
        // balance
        Route::get('/balance/{user}', 'Admin\BalanceController@index')->name('admin.user.balance');
        
        // table
        Route::get('/table', 'Admin\UserController@table')->name('admin.user.table');
        Route::get('/order/{user}/table', 'Admin\UserController@orderTable')->name('admin.user.order.table');
        Route::get('/balance/{user}/table', 'Admin\BalanceController@table')->name('admin.user.balance.table');
        Route::get('/notification/{user}/table', 'Admin\UserController@notificationTable')->name('admin.user.notification.table');
        Route::get('/order/{user}/report/{order}/table', 'Admin\OrderController@reportTable')->name('admin.user.order.report.table');

        // notification
        Route::get('/notification/{user}/create', 'Admin\NotificationController@create')->name('admin.user.notification.create');
        Route::post('/notification/{user}/post', 'Admin\NotificationController@store')->name('admin.user.notification.store');
        Route::delete('/notification/{user}/delete/{notification}', 'Admin\NotificationController@destroy')->name('admin.user.notification.destroy');
    });
    
    // Tree
    Route::resource('trees', 'Admin\TreeController')->except(['show']);

    // Product
    Route::get('trees/{tree}/products/table', 'Admin\ProductController@table')->name('admin.tree.product.table');
    Route::get('trees/{tree}/products', 'Admin\ProductController@index')->name('admin.tree.product.index');
    Route::get('trees/{tree}/products/create', 'Admin\ProductController@create')->name('admin.tree.product.create');
    Route::post('trees/{tree}/products/create', 'Admin\ProductController@store')->name('admin.tree.product.store');
    Route::get('trees/{tree}/products/edit/{product}', 'Admin\ProductController@edit')->name('admin.tree.product.edit');
    Route::put('trees/{tree}/products/edit/{product}', 'Admin\ProductController@update')->name('admin.tree.product.update');
    Route::delete('trees/{tree}/products/destroy/{product}', 'Admin\ProductController@destroy')->name('admin.tree.product.destroy');

    // Simulation
    Route::get('trees/{tree}/products/{product}/simulation/table', 'Admin\SimulationController@table')->name('admin.tree.product.simulation.table');
    Route::get('trees/{tree}/products/{product}/simulation', 'Admin\SimulationController@index')->name('admin.tree.product.simulation.index');
    Route::get('trees/{tree}/products/{product}/simulation/create', 'Admin\SimulationController@create')->name('admin.tree.product.simulation.create');
    Route::post('trees/{tree}/products/{product}/simulation/create', 'Admin\SimulationController@store')->name('admin.tree.product.simulation.store');
    Route::get('trees/{tree}/products/{product}/simulation/{simulation}/edit', 'Admin\SimulationController@edit')->name('admin.tree.product.simulation.edit');
    Route::put('trees/{tree}/products/{product}/simulation/{simulation}/edit', 'Admin\SimulationController@update')->name('admin.tree.product.simulation.update');
    Route::delete('trees/{tree}/products/{product}/simulation/{simulation}/destroy', 'Admin\SimulationController@destroy')->name('admin.tree.product.simulation.destroy');

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
    
    // banner
    Route::get('banners/table', 'Admin\BannerController@table')->name('admin.banner.table');
    Route::get('banners', 'Admin\BannerController@index')->name('admin.banner.index');
    Route::get('banners/create', 'Admin\BannerController@create')->name('admin.banner.create');
    Route::post('banners/create', 'Admin\BannerController@store')->name('admin.banner.store');
    Route::get('banners/{banner}/edit', 'Admin\BannerController@edit')->name('admin.banner.edit');
    Route::put('banners/{banner}/edit', 'Admin\BannerController@update')->name('admin.banner.update');
    Route::delete('banners/{banner}/delete', 'Admin\BannerController@destroy')->name('admin.banner.destroy');

    // description
    Route::get('descriptions/table', 'Admin\DescriptionController@table')->name('admin.description.table');
    Route::get('descriptions', 'Admin\DescriptionController@index')->name('admin.description.index');
    Route::get('descriptions/create', 'Admin\DescriptionController@create')->name('admin.description.create');
    Route::post('descriptions/create', 'Admin\DescriptionController@store')->name('admin.description.store');
    Route::get('descriptions/{description}/edit', 'Admin\DescriptionController@edit')->name('admin.description.edit');
    Route::put('descriptions/{description}/update', 'Admin\DescriptionController@update')->name('admin.description.update');
    Route::delete('descriptions/{description}/delete', 'Admin\DescriptionController@destroy')->name('admin.description.destroy');

    // FAQ
    Route::get('faq/table', 'Admin\FaqController@table')->name('admin.faq.table');
    Route::get('faq', 'Admin\FaqController@index')->name('admin.faq.index');
    Route::get('faq/create', 'Admin\FaqController@create')->name('admin.faq.create');
    Route::post('faq/create', 'Admin\FaqController@store')->name('admin.faq.store');
    Route::get('faq/{faq}/edit', 'Admin\FaqController@edit')->name('admin.faq.edit');
    Route::put('faq/{faq}/edit', 'Admin\FaqController@update')->name('admin.faq.update');
    Route::delete('faq/{faq}/destroy', 'Admin\FaqController@destroy')->name('admin.faq.destroy');
});