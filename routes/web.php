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

// Authentication
Route::get('/login', 'Auth\LoginController@loginView')->name("login");
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\RegisterController@registrationView');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/login/yubikey', 'Auth\TwoFactorController@yubikeyAuthView');
Route::post('/login/yubikey', 'Auth\TwoFactorController@yubikeyAuthPost');

Route::get('/', 'Controller@index');

// Dashboard
Route::get('/home', 'DashboardController@home');
Route::get('/new-address', 'DashboardController@newAddress');
Route::get('/addresses', 'DashboardController@addresses');
Route::get('/transactions', 'DashboardController@transactions');
Route::get('/pay', 'DashboardController@payView');
Route::post('/pay', 'DashboardController@pay');
Route::get('/transaction/{txid}', 'DashboardController@transactionView');
Route::get('/edit-label/{address}', 'DashboardController@labelEditorView');
Route::post('/edit-label/post', 'DashboardController@labelEditorPost');

// Account
Route::get('/account/2fa', 'DashboardController@accountTwoFactorIndex');
Route::get('/account/2fa/yubikey/add', 'Auth\TwoFactorController@addYubikeyView');
Route::post('/account/2fa/yubikey/add', 'Auth\TwoFactorController@addYubikey');
Route::get('/account/2fa/yubikey/delete/{yubikey}', 'Auth\TwoFactorController@deauthorizeYubikey');

//QR Generator
Route::get('/qr/{address}', 'Controller@qr');