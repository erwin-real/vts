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

use Illuminate\Support\Facades\Route;

// Reports
Route::get('/', 'HomeController@index');
Route::get('/reports', 'ReportController@template');
Route::get('/reports/show', 'ReportController@show');
Route::get('/reports/export', 'ReportController@export');
Route::get('/reports/each', 'ReportController@each');

// Change Password
Route::get('/changePassword','HomeController@showChangePasswordForm');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

// Reset Password
Route::get('/resetPassword/{id}','HomeController@showResetPasswordForm');
Route::post('/resetPassword','HomeController@resetPassword')->name('resetPassword');

// Users
Route::get('/users/create', 'HomeController@addUser');
Route::get('/users/{id}', 'HomeController@showUser');
Route::post('/users','HomeController@saveUser');
Route::get('/users','HomeController@users');
Route::get('/users/{id}/edit','HomeController@editUser');
Route::delete('/users/{id}','HomeController@destroyUser');
Route::put('/users/{id}','HomeController@updateUser');

//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('/comment', 'CommentController@newComment');

// Help
Route::get('/help', 'HomeController@help');

// Resources
Route::resources([
    'tickets' => 'TicketController',
    'depts' => 'DepartmentController'
]);