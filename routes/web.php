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
Route::group(['namespace' => 'Admin'], function () {
    Route::get('/dash', 'AdminController@index'); //后台首页
    Route::get('/admin/info/index','AdminController@admininfo');//管理员资料
    Route::get('/admin/usermember/index','AdminController@usermembershow');//用户管理界面
	Route::resource('article','ArticleController');
});

Route::get('/admin','Admin\Auth\LoginController@showLoginForm');
Route::post('/admin', 'Admin\Auth\LoginController@login');
Route::get('/admin/logout', 'Admin\Auth\LoginController@logout');


Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/reg', 'HomeController@reg');