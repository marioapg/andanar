<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	// USER
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('user/{id}', ['as' => 'user.show', 'uses' => 'UserController@show']);
	Route::put('user/profile/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
	Route::put('user/password/{id}', ['as' => 'user.updatepass', 'uses' => 'UserController@updatePass']);
	Route::get('user/create', 'UserController@create')->name('user/create');
	Route::post('user/store', ['as' => 'user.create', 'uses' => 'UserController@store']);

	// CLIENTS
	Route::get('clients', 'ClientController@index')->name('clients.index');
	Route::get('client/{id}/show', 'ClientController@show')->name('client.show');
	Route::get('client/create', 'ClientController@create')->name('client.create');
	Route::post('client', 'ClientController@store')->name('client.store');
	Route::put('client', 'ClientController@update')->name('client.update');
	Route::post('client/search', 'ClientController@search')->name('client.search');

	// INVOICES
	Route::get('invoices', 'InvoiceController@index')->name('invoices.index');
	Route::get('invoices/{type}', 'InvoiceController@index')->name('invoices.index');
	Route::get('invoice/create', 'InvoiceController@create')->name('invoice.create');
	Route::get('invoice/{id}', 'InvoiceController@show')->name('invoice.show');
	Route::put('invoice/{id}/status', 'InvoiceController@status')->name('invoice.status');
	Route::post('invoice', 'InvoiceController@store')->name('invoice.store');

	// PROFILE (self owner))
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

