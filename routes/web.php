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
Route::get('/auth', 'HomeController@auth')->name('home_auth');

Route::prefix('/dashboard')->group(function(){
    Route::get('/index', 'DashboardController@index')->name('dashboard_index');
    Route::get('/app/create', 'DashboardController@create')->name('dashboard_app_create');
    Route::get('/index', 'DashboardController@index')->name('dashboard_index');
    Route::get('/index', 'DashboardController@index')->name('dashboard_index');
});
