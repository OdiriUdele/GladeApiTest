<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')->group(function () {

    Route::post('/login', 'LoginController@login');//login user

    Route::middleware(['jwt.verify'])->group(function () {

        Route::get('/employee/all', 'ViewCompanyEmployeesController@viewEmployeesByCompanyAccount');

        Route::prefix('/admin')->group(function () {
            Route::post('/create', 'CreateAdminController@createAdmin');//create admin user
            Route::post('/delete', 'CreateAdminController@deleteteAdmin');//create admin user
        });

        Route::prefix('/company')->group(function () {
            Route::post('/create', 'CompanyController@create');//create company
            Route::get('/fetch/{company}', 'CompanyController@read')->middleware(['superadmin']);//fetch company info
            Route::post('/update/{company}', 'CompanyController@update')->middleware(['superadmin']);//update company
            Route::post('/delete/{company}', 'CompanyController@delete')->middleware(['superadmin']);//delete company
        });

        Route::prefix('/employee')->group(function () {
            Route::post('/create', 'EmployeeController@create');//create employee
            Route::get('/fetch/{employee}', 'EmployeeController@read')->middleware(['superadmin']);;//fetch employee info
            Route::post('/update/{employee}', 'EmployeeController@update')->middleware(['superadmin']);;//update employee
            Route::post('/delete/{employee}', 'EmployeeController@delete')->middleware(['superadmin']);//delete employee
        });
    });

});
