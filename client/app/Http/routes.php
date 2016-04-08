<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

});

/**
 * Route for Admin panel
 */

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/forgot-password/reset', function() {
        return 'Under Construction';
    });

    Route::get('/dashboard', 'DashboardController@getDashboard');

    Route::get('/dashboard/customer', 'AdminPanelController@getCustomer');

    Route::get('/dashboard/customer/data', 'AdminPanelController@getData');

    Route::post('dashboard/customer/status', 'AdminPanelController@getActiveOrBlock');

    Route::post('dashboard/customer/delete', 'AdminPanelController@getDelete');

    Route::post('dashboard/customer/create', 'AdminPanelController@getCreate');

    Route::post('dashboard/customer/view', 'AdminPanelController@getView');

    Route::post('dashboard/customer/edit', 'AdminPanelController@getEdit');

    Route::post('dashboard/customer/live', 'AdminPanelController@getLive');

});

/**
 * Route for Customer Portal
 */
Route::group(['middleware' => ['web']], function () {

    Route::get('/customer/login', 'CustomerController@getLoginCustomer');

    Route::post('/customer/login', 'CustomerController@postLoginCustomer');

    Route::get('/customer/register', 'CustomerController@getCustomer');

    Route::post('/customer/register/create', 'CustomerController@postCustomer');

    Route::get('/customer/portal', 'CustomerController@getCustomerPortal');

    Route::get('/customer/email/notification', 'CustomerController@getEmailNotification');

});

