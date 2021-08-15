<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
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

Route::post('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::post('/auth/check',[MainController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class, 'logout'])->name('auth.logout');



Route::group(['middleware'=>['AuthCheck']], function(){

    Route::get('/auth/login',[MainController::class, 'login'])->name('auth.login');
    Route::get('/auth/register',[MainController::class, 'register'])->name('auth.register');

    //Route for the Dashboard
    Route::get('/admin_dashboard',[MainController::class, 'dashboard']); 
});

// Route for the User Page
Route::get('admin_user', function () {
    return view('admin_user');
});
//Route for the Customer User Page
Route::get('admin_customer', function () {
    return view('admin_customer');
});
//Route for the Cleaner User Page
Route::get('admin_cleaner', function () {
    return view('admin_cleaner');
});
//Route for the Payroll Page
Route::get('admin_payroll', function () {
    return view('admin_payroll');
});
//Route for the Employee Payroll Page
Route::get('admin_employee_payroll', function () {
    return view('admin_employee_payroll');
});
//Route for the Cleaner Payroll Page
Route::get('admin_cleaner_payroll', function () {
    return view('admin_cleaner_payroll');
});
//Route for the Transaction Page
Route::get('admin_transaction', function () {
    return view('admin_transaction');
});
//Route for the Transaction History Page
Route::get('admin_transaction_history', function () {
    return view('admin_transaction_history');
});
//Route for the Services Page
Route::get('admin_services', function () {
    return view('admin_services');
});
