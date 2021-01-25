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
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('technical/session/mybudgets', 'BudgetTechnicalController@index')->name('budgets.technical.index');
	Route::get('technical/session/mybudgets/budget/{id}', 'BudgetTechnicalController@show')->name('budget.technical.show');
	Route::put('technical/session/mybudgets/budget/{id}/status', 'BudgetTechnicalController@status')->name('budget.technical.status');
	Route::get('technical/session/mybudgets/budget/{budgetid}/view/pdf', 'ViewPDFController@viewTechnical')->name('budget.technical.view.pdf');
	Route::get('technical/session/mybudgets/budget/{budgetid}/view/embed', 'BudgetTechnicalController@embedview')->name('budget.technical.view.embed');
	
	// USER
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('user/{id}', ['as' => 'user.show', 'uses' => 'UserController@show']);
	Route::delete('user/delete/{id}', ['as' => 'user.delete', 'uses' => 'UserController@delete']);
	Route::put('user/profile/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
	Route::put('user/password/{id}', ['as' => 'user.updatepass', 'uses' => 'UserController@updatePass']);
	Route::get('user/create', 'UserController@create')->name('user/create');
	Route::post('user/store', ['as' => 'user.create', 'uses' => 'UserController@store']);

	// CLIENTS
	Route::get('clients', 'ClientController@index')->name('clients.index');
	Route::get('client/{id}/show', 'ClientController@show')->name('client.show');
	Route::delete('client/delete/{id}', 'ClientController@delete')->name('client.delete');
	Route::get('client/create', 'ClientController@create')->name('client.create');
	Route::post('client', 'ClientController@store')->name('client.store');
	Route::put('client', 'ClientController@update')->name('client.update');
	Route::post('client/search', 'ClientController@search')->name('client.search');

	// BUDGETS
	Route::get('budgets', 'BudgetController@index')->name('budgets.index');
	Route::get('budget/create/step-1', 'BudgetController@createStepOne')->name('budget.create.step.one');
	Route::post('budget/create/step-1', 'BudgetController@storeStepOne')->name('budget.create.step.one');
	
	Route::get('budget/create/step-2', 'BudgetController@createStepTwo')->name('budget.create.step.two');
	Route::post('budget/create/step-2', 'BudgetController@storeStepTwo')->name('budget.create.step.two');

	Route::get('budget/create/step-3', 'BudgetController@createStepThree')->name('budget.create.step.three');
	Route::post('budget/create/step-3', 'BudgetController@storeStepThree')->name('budget.create.step.three');

	Route::get('budget/create/step-4', 'BudgetController@createStepFour')->name('budget.create.step.four');
	Route::post('budget/create/step-4', 'BudgetController@storeStepFour')->name('budget.create.step.four');

	Route::get('budget/{id}', 'BudgetController@show')->name('budget.show');
	Route::put('budget/{id}/status', 'BudgetController@status')->name('budget.status');
	Route::post('budget', 'BudgetController@store')->name('budget.store');
	Route::delete('budget', 'BudgetController@delete')->name('budget.delete');
	Route::get('budget/{id}/edit', 'BudgetController@edit')->name('budget.edit');
	Route::put('budget/{budget_id}', 'BudgetController@update')->name('budget.update');
	Route::get('budget/{id}/users/allowed', 'BudgetController@alloweds')->name('budget.allowed');
	Route::put('budget/{id}/users/allowed', 'BudgetController@autorize')->name('budgets.autorize');
	Route::post('export/budgets', 'ExportReportController@export')->name('export.budgets');
	
	Route::post('budget/{budgetid}/mail/send', 'BudgetMailsController@send')->name('budget.send.mail');
	Route::get('budget/{budgetid}/view/pdf', 'ViewPDFController@view')->name('budget.view.pdf');
	Route::get('budget/{budgetid}/view/embed', 'BudgetController@embedview')->name('budget.view.embed');


	// PROFILE (self owner))
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	// CAR
	Route::get('cars', ['as' => 'cars.index', 'uses' => 'CarController@index']);
	Route::get('cars/{id}', ['as' => 'car.show', 'uses' => 'CarController@show']);
	Route::put('cars/{id}', ['as' => 'car.update', 'uses' => 'CarController@update']);
	Route::delete('cars/{id}', ['as' => 'car.delete', 'uses' => 'CarController@delete']);
	Route::get('car/create', ['as' => 'car.create', 'uses' => 'CarController@create']);
	Route::post('car/store', ['as' => 'car.store', 'uses' => 'CarController@store']);

	Route::get('cars/{brand}/models', ['as' => 'car.models.by.brand', 'uses' => 'DBModelController@index']);

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