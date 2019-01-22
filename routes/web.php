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
Auth::routes();

// Front pages
Route::get('/', 'HomeController@index');
Route::get('/tentang-kami', 'HomeController@about')->name('tentang-kami');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/layanan', 'HomeController@service')->name('layanan');

// Route::get('/home', 'HomeController@index')->name('home');
