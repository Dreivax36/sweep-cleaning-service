<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
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
Route::get('/destroy/{id}',[ServiceController::class, 'destroy'])->name('destroy');
Route::post('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/update',[ServiceController::class, 'update'])->name('update');
Route::get('/admin_services',[ServiceController::class, 'admin_services'])->name('admin_services'); 
Route::get('/customer/customer_services',[ServiceController::class, 'customer_services'])->name('customer.customer_services');

//Admin
Route::POST('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::POST('/auth/check',[MainController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class, 'logout'])->name('auth.logout');

//Booking Module
Route::post('/updateStatus',[BookingController::class, 'updateStatus'])->name('updateStatus');
Route::get('/customer/customer_transaction',[BookingController::class, 'customer_transaction'])->name('customer.customer_transaction');
Route::get('/customer/customer_history',[BookingController::class, 'customer_history'])->name('customer.customer_history');
Route::get('/cleaner/cleaner_job',[BookingController::class, 'cleaner_job'])->name('cleaner.cleaner_job');
Route::get('/cleaner/cleaner_history',[BookingController::class, 'cleaner_history'])->name('cleaner.cleaner_history');

//Customer
Route::post('/customer/customer_save',[MainController::class, 'customer_save'])->name('customer.customer_save');
Route::post('/customer/customer_check',[MainController::class, 'customer_check'])->name('customer.customer_check');
Route::post('customer/book',[BookingController::class, 'book'])->name('book');

//Cleaner
Route::post('/cleaner/cleaner_save',[MainController::class, 'cleaner_save'])->name('cleaner.cleaner_save');
Route::post('/cleaner/cleaner_check',[MainController::class, 'cleaner_check'])->name('cleaner.cleaner_check');
Route::post('cleaner/book',[BookingController::class, 'book'])->name('book');



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
    Route::get('/customer/customer_profile',[MainController::class, 'customer_profile'])->name('customer.customer_profile');

    //Route for Cleaner App
    Route::get('/cleaner/cleaner_login',[MainController::class, 'cleaner_login'])->name('cleaner.cleaner_login');
    Route::get('/cleaner/cleaner_register',[MainController::class, 'cleaner_register'])->name('cleaner.cleaner_register');
    Route::get('/cleaner/cleaner_dashboard',[MainController::class, 'cleaner_dashboard'])->name('cleaner.cleaner_dashboard');

});



//Route for the Sweep Welcome Page
Route::get('sweep_welcome', function () {
    return view('sweep_welcome');
}); 
//Route for the About Us Page
Route::get('sweep_about_us', function () {
    return view('sweep_about_us');
}); 
//Route for the FAQs Page
Route::get('sweep_faqs', function () {
    return view('sweep_faqs');
}); 
//Route for the Contact Us Page
Route::get('sweep_contact_us', function () {
    return view('sweep_contact_us');
}); 


//Route for the Admin Dashboard Page
Route::get('admin_dashboard', function () {
    return view('admin_dashboard');
});
// Route for the Services Page
Route::get('admin_services', function () {
    return view('admin_services');
});
//Route for the Transaction Page
Route::get('admin_transaction', function () {
    return view('admin_transaction');
});
//Route for the Transaction History Page
Route::get('admin_transaction_history', function () {
    return view('admin_transaction_history');
});
//Route for the Cleaner Payroll Page
Route::get('admin_payroll_cleaner', function () {
    return view('admin_payroll_cleaner');
});
//Route for the Employee Payroll Page
Route::get('admin_payroll_employee', function () {
    return view('admin_payroll_employee');
});
//Route for the Payroll Page
Route::get('admin_payroll', function () {
    return view('admin_payroll');
});
// Route for the User Page
Route::get('admin_user', function () {
    return view('admin_user');
});
//Route for the Cleaner User Page
Route::get('admin_user_cleaner', function () {
    return view('admin_user_cleaner');
});
//Route for the Customer User Page
Route::get('admin_user_customer', function () {
    return view('admin_user_customer');
});



//Route for the Cleaner Login Page
Route::get('cleaner/cleaner_login', function () {
    return view('cleaner/cleaner_login');
});
//Route for the Cleaner Register Page
Route::get('cleaner/cleaner_register', function () {
    return view('cleaner/cleaner_register');
});
//Route for the Cleaner Dashboard Page
Route::get('cleaner/cleaner_dashboard', function () {
    return view('cleaner/cleaner_dashboard');
});
//Route for the Cleaner Job Page
Route::get('cleaner/cleaner_job', function () {
    return view('cleaner/cleaner_job');
});
//Route for the Cleaner History Page
Route::get('cleaner/cleaner_history', function () {
    return view('cleaner/cleaner_history');
});
//Route for the Cleaner Profile Page
Route::get('cleaner/cleaner_profile', function () {
    return view('cleaner/cleaner_profile');
});


//Route for the Customer Login Page
Route::get('customer/customer_login', function () {
    return view('customer/customer_login');
});
//Route for the Customer Register Page
Route::get('customer/customer_register', function () {
    return view('customer/customer_register');
});
//Route for the Customer Dashboard Page
Route::get('customer/customer_dashboard', function () {
    return view('customer/customer_dashboard');
});
//Route for the Customer Services Page
Route::get('customer/customer_services', function () {
    return view('customer/customer_services');
});
//Route for the Customer Transaction Page
Route::get('customer/customer_transaction', function () {
    return view('customer/customer_transaction');
});
//Route for the Customer History Page
Route::get('customer/customer_history', function () {
    return view('customer/customer_history');
});
//Route for the Customer Profile Page
Route::get('customer/customer_profile', function () {
    return view('customer/customer_profile');
});




