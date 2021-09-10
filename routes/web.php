<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
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
Route::get('/store',[ServiceController::class, 'store'])->name('store');
Route::post('/destroy',[ServiceController::class, 'destroy'])->name('destroy');
Route::post('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/admin_services',[ServiceController::class, 'admin_services'])->name('admin_services'); 
Route::get('/admin_transaction',[ServiceController::class, 'admin_transaction'])->name('admin_transaction');
Route::get('/admin_transaction_history',[ServiceController::class, 'admin_transaction_history'])->name('admin_transaction_history'); 
Route::get('/customer/customer_services',[ServiceController::class, 'customer_services'])->name('customer.customer_services');

//Admin
Route::POST('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::POST('/auth/check',[MainController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class, 'logout'])->name('auth.logout');
Route::get('/update_account/{id}',[MainController::class, 'update_account'])->name('update_account');

//Booking Module
Route::post('/updateStatus/{id}',[BookingController::class, 'updateStatus'])->name('updateStatus');
Route::post('/assignCleaner',[BookingController::class, 'assignCleaner'])->name('assignCleaner');
Route::post('/cleaner',[BookingController::class, 'cleaner'])->name('cleaner');
Route::get('/customer/customer_transaction',[BookingController::class, 'customer_transaction'])->name('customer.customer_transaction');
Route::get('/customer/customer_history',[BookingController::class, 'customer_history'])->name('customer.customer_history');
Route::get('/cleaner/cleaner_job',[BookingController::class, 'cleaner_job'])->name('cleaner.cleaner_job');
Route::get('/cleaner/cleaner_history',[BookingController::class, 'cleaner_history'])->name('cleaner.cleaner_history');

//Customer


//Cleaner
Route::post('/cleaner/cleaner_save',[MainController::class, 'cleaner_save'])->name('cleaner.cleaner_save');
Route::post('/cleaner/cleaner_check',[MainController::class, 'cleaner_check'])->name('cleaner.cleaner_check');




Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/',[MainController::class, 'sweep_welcome'])->name('sweep_welcome');
    //Route for Admin Pages
    Route::get('/auth/login',[MainController::class, 'login'])->name('auth.login');
    Route::get('/auth/register',[MainController::class, 'register'])->name('auth.register');
    Route::get('/admin_dashboard',[MainController::class, 'admin_dashboard'])->name('admin_dashboard'); 
    Route::get('/admin_user',[MainController::class, 'admin_user'])->name('admin_user'); 
    Route::get('/admin_user_customer',[MainController::class, 'admin_user_customer'])->name('admin_user_customer'); 
    Route::get('/admin_user_cleaner',[MainController::class, 'admin_user_cleaner'])->name('admin_user_cleaner'); 
    Route::get('/admin_payroll',[MainController::class, 'admin_payroll'])->name('admin_payroll'); 
    Route::get('/admin_payroll_cleaner',[MainController::class, 'admin_payroll_cleaner'])->name('admin_payroll_cleaner'); 
    Route::get('/admin_payroll_employee',[MainController::class, 'admin_payroll_employee'])->name('admin_payroll_employee'); 

    //Route for Customer Pages
    Route::get('/customer/customer_login',[MainController::class, 'customer_login'])->name('customer.customer_login');
    Route::get('/customer/customer_register',[MainController::class, 'customer_register'])->name('customer.customer_register');
    Route::get('/customer/customer_dashboard',[MainController::class, 'customer_dashboard'])->name('customer.customer_dashboard');
    Route::get('/customer/customer_profile',[MainController::class, 'customer_profile'])->name('customer.customer_profile');
    Route::post('/updateProfile',[MainController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/updateProfile',[MainController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/customer/customer_save',[MainController::class, 'customer_save'])->name('customer.customer_save');
    Route::post('/customer/customer_check',[MainController::class, 'customer_check'])->name('customer.customer_check');
    Route::post('/book',[BookingController::class, 'book'])->name('book');

    //Route for Cleaner App
    Route::get('/cleaner/cleaner_login',[MainController::class, 'cleaner_login'])->name('cleaner.cleaner_login');
    Route::get('/cleaner/cleaner_register',[MainController::class, 'cleaner_register'])->name('cleaner.cleaner_register');
    Route::get('/cleaner/cleaner_dashboard',[MainController::class, 'cleaner_dashboard'])->name('cleaner.cleaner_dashboard');
    Route::get('/cleaner/cleaner_profile',[MainController::class, 'cleaner_profile'])->name('cleaner.cleaner_profile');
    Route::get('/updateCleaner',[MainController::class, 'updateCleaner'])->name('updateCleaner');
    Route::post('/updateCleaner',[MainController::class, 'updateCleaner'])->name('updateCleaner');


});





