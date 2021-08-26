<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ServiceController;
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

//Service Module
Route::resource('services', ServiceController::class);
Route::post('/store',[ServiceController::class, 'store'])->name('store');
Route::get('/destroy/{id}',[ServiceController::class, 'destroy'])->name('destroy');
Route::post('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/admin_services',[ServiceController::class, 'admin_services'])->name('admin_services'); 


//Admin
Route::POST('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::POST('/auth/check',[MainController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class, 'logout'])->name('auth.logout');
Route::post('/addService',[MainController::class, 'addService'])->name('addService');
Route::post('/deleteService',[MainController::class, 'deleteService'])->name('deleteService');
Route::get('/deleteService/{service_id}',[MainController::class, 'deleteService'])->name('deleteService');
Route::post('/updateStatus',[MainController::class, 'updateStatus'])->name('updateStatus');


//Customer
Route::post('/customer/customer_save',[MainController::class, 'customer_save'])->name('customer.customer_save');
Route::post('/customer/customer_check',[MainController::class, 'customer_check'])->name('customer.customer_check');
Route::post('customer/book',[MainController::class, 'book'])->name('book');

//Cleaner
Route::post('/cleaner/cleaner_save',[MainController::class, 'cleaner_save'])->name('cleaner.cleaner_save');
Route::post('/cleaner/cleaner_check',[MainController::class, 'cleaner_check'])->name('cleaner.cleaner_check');
Route::post('cleaner/book',[MainController::class, 'book'])->name('book');



Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/',[MainController::class, 'sweep_welcome'])->name('sweep_welcome');
    //Route for Admin Pages
    Route::get('/auth/login',[MainController::class, 'login'])->name('auth.login');
    Route::get('/auth/register',[MainController::class, 'register'])->name('auth.register');
    Route::get('/admin_dashboard',[MainController::class, 'admin_dashboard'])->name('admin_dashboard'); 

    //Route for Customer Pages
    Route::get('/customer/customer_login',[MainController::class, 'customer_login'])->name('customer.customer_login');
    Route::get('/customer/customer_register',[MainController::class, 'customer_register'])->name('customer.customer_register');
    Route::get('/customer/customer_dashboard',[MainController::class, 'customer_dashboard'])->name('customer.customer_dashboard');
    Route::get('/customer/customer_services',[MainController::class, 'customer_services'])->name('customer.customer_services');
    Route::get('/customer/customer_transaction',[MainController::class, 'customer_transaction'])->name('customer.customer_transaction');
    Route::get('/customer/customer_history',[MainController::class, 'customer_history'])->name('customer.customer_history');
    Route::get('/customer/customer_profile',[MainController::class, 'customer_profile'])->name('customer.customer_profile');

    //Route for Cleaner App
    Route::get('/cleaner/cleaner_login',[MainController::class, 'cleaner_login'])->name('cleaner.cleaner_login');
    Route::get('/cleaner/cleaner_register',[MainController::class, 'cleaner_register'])->name('cleaner.cleaner_register');
    Route::get('/cleaner/cleaner_dashboard',[MainController::class, 'cleaner_dashboard'])->name('cleaner.cleaner_dashboard');
    Route::get('/cleaner/cleaner_job',[MainController::class, 'cleaner_job'])->name('cleaner.cleaner_job');
    Route::get('/cleaner/cleaner_history',[MainController::class, 'cleaner_history'])->name('cleaner.cleaner_history');

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
