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
Route::group(['middleware' => ['web']], function () {
    Auth::routes();
});
/*Multi step form*/
Route::group(['middleware' => ['frontend']], function () {
    Route::get('/', 'CheckInController@index');
    Route::get('/check-in', [
        'as' => 'check-in',
        'uses' => 'CheckInController@index'
    ]);
    Route::get('/check-in/create-step-one', [
        'as' => 'check-in.step-one',
        'uses' => 'CheckInController@createStepOne'
    ]);

    Route::post('/check-in/create-step-one', [
        'as' => 'check-in.step-one.next',
        'uses' => 'CheckInController@postCreateStepOne'
    ]);

    Route::get('/check-in/create-step-two', [
        'as' => 'check-in.step-two',
        'uses' => 'CheckInController@createStepTwo'
    ]);

    Route::post('/check-in/create-step-two', [
        'as' => 'check-in.step-two.next',
        'uses' => 'CheckInController@postCreateStepTwo'
    ]);
    Route::get('/run-fast', 'CheckInController@createStepThree');

    Route::post('/check-in/create-step-three', [
        'as' => 'check-in.step-three.next',
        'uses' => 'CheckInController@store'
    ]);
    Route::get('/check-in/show/{id}', [
        'as' => 'check-in.show',
        'uses' => 'CheckInController@show'
    ]);
    Route::get('/check-in/return', [
        'as' => 'check-in.return',
        'uses' => 'CheckInController@visitor_return'
    ]);
    Route::post('/check-in/return', [
        'as' => 'check-in.find.visitor',
        'uses' => 'CheckInController@find_visitor'
    ]);

    Route::get('/check-in/pre-registered', [
        'as' => 'check-in.pre.registered',
        'uses' => 'CheckInController@pre_registered'
    ]);
    Route::post('/check-in/pre-registered', [
        'as' => 'check-in.find.pre.visitor',
        'uses' => 'CheckInController@find_pre_visitor'
    ]);
});

/*Installer Routes*/
/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
*/
Route::group([
    'middleware' => ['web']
], function () {
    Route::get('install', 'InstallController@starting');
    Route::get('install/site_info', 'InstallController@siteInfo');
    Route::post('install/site_info', 'InstallController@siteInfo');
    Route::get('install/system_compatibility', 'InstallController@systemCompatibility');
    Route::get('install/database', 'InstallController@database');
    Route::post('install/database', 'InstallController@database');
    Route::get('install/database_import', 'InstallController@databaseImport');
    Route::get('install/cron_jobs', 'InstallController@cronJobs');
    Route::get('install/finish', 'InstallController@finish');
});
/*Finished Install*/




Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => 'admin'], function () {

    Route::get('/', [
        'as' => 'admin',
        'uses' => 'AdminController@index'
    ]);

    Route::post('delete/{id}', [
        'as' => 'admin.destroy',
        'uses' => 'AdminController@destroy'
    ]);
    Route::get('profile', [
        'as' => 'admin.profile',
        'uses' => 'AdminController@profile'
    ]);
    Route::get('profile', [
        'as' => 'admin.profile',
        'uses' => 'AdminController@profile'
    ]);

    Route::post('send/email', 'AdminController@sendEmail');
    Route::post('export', 'AdminController@export');

    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
    Route::resource('activitylogs', 'ActivityLogsController')->only([
        'index', 'show', 'destroy'
    ]);
    Route::get('settings/{type?}', [
        'as' => 'admin.settings.general',
        'uses' => 'SettingsController@create'
    ]);
    Route::post('settings/{type?}', [
        'as' => 'admin.settings.general',
        'uses' => 'SettingsController@store'
    ]);

// Visitors Routes ===========================>

    Route::get('visitors', [
        'as' => 'admin.visitors',
        'uses' => 'visitorsController@index'
    ]);
    Route::get('visitors/create', [
        'as' => 'admin.visitors.create',
        'uses' => 'visitorsController@create'
    ]);

    Route::get('visitors/{id}/edit', [
        'as' => 'admin.visitors.edit',
        'uses' => 'visitorsController@edit'
    ]);

    Route::get('visitors/show/{id}', [
        'as' => 'admin.visitors.show',
        'uses' => 'visitorsController@show'
    ]);

    Route::post('visitors/store', [
        'as' => 'admin.visitors.store',
        'uses' => 'visitorsController@store'
    ]);

    Route::put('visitors/update/{id}', [
        'as' => 'admin.visitors.update',
        'uses' => 'visitorsController@update'
    ]);

    Route::put('visitors/check_in/{id}', [
        'as' => 'admin.visitors.check_in',
        'uses' => 'visitorsController@check_in'
    ]);
    Route::put('visitors/check_out', [
        'as' => 'admin.visitors.check_out',
        'uses' => 'visitorsController@check_out'
    ]);

    Route::delete('visitors/delete/{id}', [
        'as' => 'admin.visitors.destroy',
        'uses' => 'visitorsController@destroy'
    ]);

    Route::post('visitors/sendEmail', 'visitorsController@sendEmail');


    Route::post('visitors/export', 'visitorsController@export');
    Route::post('visitors/date', 'visitorsController@datevalue');

// pre_register Routes ===========================>

    Route::get('pre_register', 'pre_registerController@index');

    Route::get('pre_register/create', [
        'as' => 'admin.pre_register.create',
        'uses' => 'pre_registerController@create'
    ]);

    Route::get('pre_register/{id}/edit', [
        'as' => 'admin.pre_register.edit',
        'uses' => 'pre_registerController@edit'
    ]);

    Route::get('pre_register/{id}/show', [
        'as' => 'admin.pre_register.show',
        'uses' => 'pre_registerController@show'
    ]);

    Route::post('pre_register/store', [
        'as' => 'admin.pre_register.store',
        'uses' => 'pre_registerController@store'
    ]);

    Route::put('pre_register/update/{id}', [
        'as' => 'admin.pre_register.update',
        'uses' => 'pre_registerController@update'
    ]);


    Route::delete('pre_register/delete/{id}', [
        'as' => 'admin.pre_register.destroy',
        'uses' => 'pre_registerController@destroy'
    ]);

    Route::post('pre_register/sendEmail', 'pre_registerController@sendEmail');

    Route::post('pre_register/export', 'pre_registerController@export');
    Route::post('pre_register/date', 'pre_registerController@datevalue');


// employees Routes ===========================>

    Route::get('employees', 'EmployeesController@index');

    Route::get('employees/create', [
        'as' => 'admin.employees.create',
        'uses' => 'EmployeesController@create'
    ]);

    Route::get('employees/{id}/edit', [
        'as' => 'admin.employees.edit',
        'uses' => 'EmployeesController@edit'
    ]);

    Route::get('employees/{id}/show', [
        'as' => 'admin.employees.show',
        'uses' => 'EmployeesController@show'
    ]);

    Route::post('employees/store', [
        'as' => 'admin.visitors.store',
        'uses' => 'EmployeesController@store'
    ]);

    Route::put('employees/update/{id}', [
        'as' => 'admin.employees.update',
        'uses' => 'EmployeesController@update'
    ]);


    Route::delete('employees/delete/{id}', [
        'as' => 'admin.employees.destroy',
        'uses' => 'EmployeesController@destroy'
    ]);

    Route::put('employees/check_in/{id}', [
        'as' => 'admin.employees.check_in',
        'uses' => 'EmployeesController@check_in'
    ]);
    Route::put('employees/check_out/{id}', [
        'as' => 'admin.employees.check_out',
        'uses' => 'EmployeesController@check_out'
    ]);

    Route::post('employees/sendEmail', 'EmployeesController@sendEmail');
    Route::post('employees/export', 'EmployeesController@export');
    Route::post('employees/date', 'EmployeesController@datevalue');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'employees', 'middleware' => ['auth']], function () {
    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'EmployeesController@index'
    ]);
    Route::get('profile', [
        'as' => 'employees.profile',
        'uses' => 'EmployeesController@profile'
    ]);
    Route::get('{id}/edit', [
        'as' => 'employees.edit',
        'uses' => 'EmployeesController@profile_edit'
    ]);
    Route::get('attendance', [
        'as' => 'employees.attendance',
        'uses' => 'EmployeesController@attendance'
    ]);
    Route::put('checkin_out/{id}', [
        'as' => 'employees.checkin_out',
        'uses' => 'EmployeesController@checkin_out'
    ]);
    Route::put('update/{id}', [
        'as' => 'employees.update',
        'uses' => 'EmployeesController@ProfileUpdate'
    ]);
    Route::get('pre-register', [
        'as' => 'employees.pre-register',
        'uses' => 'EmployeesController@pre_register'
    ]);
    Route::get('pre-register/create', [
        'as' => 'employees.pre-register.create',
        'uses' => 'EmployeesController@pre_register_create'
    ]);
    Route::post('pre_register/store', [
        'as' => 'employees.pre-register.store',
        'uses' => 'EmployeesController@pre_register_store'
    ]);
    Route::get('pre_register/{id}/edit', [
        'as' => 'pre_register.edit',
        'uses' => 'EmployeesController@pre_register_edit'
    ]);
    Route::put('pre_register/update/{id}', [
        'as' => 'employees.pre_register.update',
        'uses' => 'EmployeesController@pre_register_update'
    ]);
    Route::delete('pre_register/delete/{id}', [
        'as' => 'employees.pre_register.destroy',
        'uses' => 'EmployeesController@pre_register_destroy'
    ]);
    Route::get('visitors/show/{id}', [
        'as' => 'employees.visitors.show',
        'uses' => 'EmployeesController@visitor_show'
    ]);
});
