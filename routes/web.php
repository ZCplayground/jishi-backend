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

Route::get('/', 'StaticPagesController@home');
Route::get('/help', 'StaticPagesController@help');
Route::get('/about', 'StaticPagesController@about');


/* 
UsersController：

功能|url|http方法|接口
---|---|---|---
注册|/signup|post|
登陆|/login |post|
退出登陆|/logout|delete|
忘记密码1（验证手机号）|/password_forget|post|
忘记密码2（输入新密码）|/password_reset|post|
*/
Route::post('/signup', 'UsersController@signup')->name('signup');
Route::post('/login','UsersController@login')->name('login');
Route::delete('/logout','UsersController@logout')->name('logout');
Route::post('/password_forget','UsersController@passwdForget')->name('passwdForget');
Route::post('/password_reset','UsersController@passwdReset')->name('passwdReset');

Route::get('/recommend', 'RecommendController@recommend')->name('recommend');