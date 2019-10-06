<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\LoginController@auth');
});

Route::group(['middleware' => ['cors', 'auth:api']], function (){
    Route::resource('user', 'UserController');
    Route::resource('company', 'Catalogs\CompanyController');
    Route::resource('contractTypes', 'Catalogs\ContractTypesController');
    Route::resource('contributionBases', 'Catalogs\ContributionBasesController');
    Route::resource('employeeTypes', 'Catalogs\EmployeeTypesController');
    Route::resource('workShifts', 'Catalogs\WorkShiftsController');
    Route::resource('paymentMethods', 'Catalogs\PaymentMethodsController');
    Route::resource('sexs', 'Catalogs\SexsController');
    Route::resource('discountTypes', 'Catalogs\DiscountTypesController');
    Route::resource('periodTypes', 'Catalogs\PeriodTypesController');
});


