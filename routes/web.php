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

Route::get('/', 'HomeController@index')->name('home_index');
Route::any('/redirect', 'HomeController@redirect')->name('home_redirect');

Route::get('/auth', 'AuthController@auth')->name('auth');
Route::post('/auth', 'AuthController@authFromPost')->name('auth_from_post');

Route::post('/callback', 'HomeController@callback')->name('callback');

Route::prefix('/dashboard')->group(function(){
    Route::get('/index', 'DashboardController@index')->name('dashboard_index');
});
