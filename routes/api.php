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
    Route::post('/logout','LogoutController@logout')->middleware(['jwt.verify','jwt.auth']);//logout user

    Route::middleware(['jwt.verify','jwt.auth'])->group(function () {

        Route::middleware(['check-role:company,employee'])->group(function () {

            // fetch employees with company account
            Route::get('/employee/all', 'CompanyAndEmployeeController@viewEmployeesByCompanyAccount')->middleware(['check-role:company']);

            //fetch company info with employee account
            Route::get('/company/info', 'CompanyAndEmployeeController@viewCompanyByEmployeeAccount')->middleware(['check-role:employee']);
        });

        Route::prefix('/admin')->group(function () {
            Route::post('/create', 'AdminCRUDController@create');//create admin user
            Route::post('/delete/{admin}', 'AdminCRUDController@delete')->middleware(['superadmin']);//delete admin user
        });

        Route::prefix('/ops')->group(function () {
            Route::get('/fetch-companies', 'AdminFetchOperationsController@fetchCompanies');//fetch all companies
            Route::get('/fetch-employees', 'AdminFetchOperationsController@fetchEmployees');//fetch all employees
            Route::get('/{company}/fetch-employees', 'AdminFetchOperationsController@fetchCompanyEmployees');//fetch all company employees
        });

        Route::prefix('/company')->group(function () {
            Route::post('/create', 'CompanyController@create');//create company
            Route::get('/fetch/{company}', 'CompanyController@read')->middleware(['superadmin']);//fetch company info
            Route::post('/update/{company}', 'CompanyController@update')->middleware(['superadmin']);//update company
            Route::post('/delete/{company}', 'CompanyController@delete')->middleware(['superadmin']);//delete company
        });

        Route::prefix('/employee')->group(function () {
            Route::post('/create', 'EmployeeController@create');//create employee
            Route::get('/fetch/{employee}', 'EmployeeController@read')->middleware(['superadmin']);//fetch employee info
            Route::post('/update/{employee}', 'EmployeeController@update')->middleware(['superadmin']);//update employee
            Route::post('/delete/{employee}', 'EmployeeController@delete')->middleware(['superadmin']);//delete employee
        });

        Route::post('/company/audit', 'CompanyCreationAuditController@audit');//Superadmin see whhich Admin created a company

    });

});
