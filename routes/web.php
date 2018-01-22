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

Route::get('/', 'Controller@index');
Route::get('/login', 'Auth\LoginController@loginView');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\RegisterController@registrationView');
Route::post('/register', 'Auth\RegisterController@register');

// Dashboard
Route::get('/home', 'DashboardController@home');

//QR Generator
Route::get('/qr-code/{address}', 'Controller@qr');
Route::get('/qr-code/{address}', 'Controller@qr');