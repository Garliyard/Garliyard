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
Route::get('/new-address', 'DashboardController@newAddress');
Route::get('/addresses', 'DashboardController@addresses');
Route::get('/transactions', 'DashboardController@transactions');
Route::get('/pay', 'DashboardController@payView');
Route::post('/pay', 'DashboardController@pay');
Route::get('/transaction/{txid}', 'DashboardController@transactionView');

//QR Generator
Route::get('/qr-code/{address}', 'Controller@qr');