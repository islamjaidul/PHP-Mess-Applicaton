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

    Route::get('/login', 'Auth\AuthController@getLogin');

    //Route::get('admin/login', 'Auth\AuthController@getAdminLogin');

    Route::get('/register', function() {
        return 'Sorry this page is not available anymore';
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

    Route::get('dashboard/customer/check-before-expire', 'AdminPanelController@getCheckBeforeExpiration');

    Route::get('dashboard/customer/expire', 'AdminPanelController@getExpired');

    Route::post('dashboard/admin/register', 'AdminPanelController@adminRegistration');

    Route::get('dashboard/setting', 'AdminPanelController@getAdminSetting');

    Route::post('dashboard/setting/change', 'AdminPanelController@postAdminSetting');

    Route::get('dashboard/customer/test', 'AdminPanelController@getTest');

});

/**
 * Route for Customer Portal
 */
Route::group(['middleware' => ['web']], function () {

    Route::get('/customer/login', 'CustomerController@getLoginCustomer');

    Route::post('/customer/login', 'CustomerController@postLoginCustomer');

    Route::get('/customer/logout', 'CustomerController@getLogoutCustomer');

    Route::get('/customer/register', 'CustomerController@getCustomer');

    Route::post('/customer/register/create', 'CustomerController@postCustomer');

    Route::get('/customer/portal', 'CustomerController@getCustomerPortal');

    Route::get('/customer/email/notification', 'CustomerController@getEmailNotification');

    Route::get('/customer/account/extend', function() {
        return 'This system is under construction';
    });

});

/**
 * Route for password reset
 */
Route::group(['middleware' => ['web']], function() {
    //Route::get('admin/forgot-password', 'PasswordController@getAdminReset');

    Route::get('customer/forgot-password', 'PasswordController@getCustomerReset');

    Route::post('customer/reset', 'PasswordController@postCustomerReset');

    Route::get('customer/reset/password', 'PasswordController@getCustomerPasswordReset');

    Route::post('customer/reset/password', 'PasswordController@postCustomerPasswordReset');
});

