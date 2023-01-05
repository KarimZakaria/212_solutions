<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EmployeeController::class, 'index']);

Route::get('companies/all', [CompanyController::class, 'getCompanies'])->name('getCompanies');
Route::resource('companies', CompanyController::class);
Route::get('employees/all', [EmployeeController::class, 'getEmployees'])->name('getEmployees');
Route::get('employees/filter/{id}', [EmployeeController::class, 'getEmployeesByCompany'])->name('getEmployeesByCompany');
Route::resource('employees', EmployeeController::class);
