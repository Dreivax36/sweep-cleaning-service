<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\AuthCheck;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EWalletPaymentController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\MailSend;
use App\Models\User;
use App\Notifications\NotifyUser;
use Pusher\Pusher;

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

//Admin
Route::POST('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::POST('/auth/check',[MainController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class, 'logout'])->name('auth.logout');
Route::get('/logout_cleaner',[MainController::class, 'logout_cleaner'])->name('logout_cleaner');


//Customer
Route::post('/customer/customer_save',[MainController::class, 'customer_save'])->name('customer.customer_save');
Route::get('/customer/customer_save',[MainController::class, 'customer_save'])->name('customer.customer_save');
Route::post('/customer/customer_check',[MainController::class, 'customer_check'])->name('customer.customer_check');

//Cleaner
Route::post('/cleaner/cleaner_save',[MainController::class, 'cleaner_save'])->name('cleaner.cleaner_save');
Route::post('/cleaner/cleaner_check',[MainController::class, 'cleaner_check'])->name('cleaner.cleaner_check');

  //Calendar
  Route::get('cleaner/cleaner_dashboard', [FullCalendarController::class, 'index']);
  Route::get('cleaner/cleaner_dashboard/action', [FullCalendarController::class, 'action']);

Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/',[MainController::class, 'sweep_welcome'])->name('sweep_welcome');
    //Route for Admin Pages
    Route::get('/auth/login',[MainController::class, 'login'])->name('auth.login');
    Route::get('/auth/register',[MainController::class, 'register'])->name('auth.register');
    Route::get('/verify/{id}',[MainController::class, 'verify'])->name('verify');
    Route::get('/verify_cleaner/{id}',[MainController::class, 'verify'])->name('verify');
    Route::get('/admin_dashboard',[MainController::class, 'admin_dashboard'])->name('admin_dashboard'); 
    Route::get('/admin_user',[MainController::class, 'admin_user'])->name('admin_user'); 
    Route::get('/admin_user_customer',[MainController::class, 'admin_user_customer'])->name('admin_user_customer'); 
    Route::get('/admin_user_cleaner',[MainController::class, 'admin_user_cleaner'])->name('admin_user_cleaner'); 
    //Route::get('/admin_payroll',[MainController::class, 'admin_payroll'])->name('admin_payroll'); 
    Route::get('/admin_payroll_cleaner',[MainController::class, 'admin_payroll_cleaner'])->name('admin_payroll_cleaner'); 
    Route::get('/admin_payroll',[MainController::class, 'admin_payroll_employee'])->name('admin_payroll_employee'); 
    Route::get('/admin_reports',[MainController::class, 'admin_reports'])->name('admin_reports'); 
    Route::get('/admin_user_employees',[MainController::class, 'admin_user_employees'])->name('admin_user_employees'); 
    Route::post('/addEmployee',[MainController::class, 'addEmployee'])->name('addEmployee');

    //Route for Customer Pages
    Route::get('/customer/customer_login',[MainController::class, 'customer_login'])->name('customer.customer_login');
    Route::get('/customer/customer_register',[MainController::class, 'customer_register'])->name('customer.customer_register');
    Route::get('/customer/customer_dashboard',[MainController::class, 'customer_dashboard'])->name('customer.customer_dashboard');
    Route::get('/customer/customer_profile',[MainController::class, 'customer_profile'])->name('customer.customer_profile');
    Route::post('/updateProfile',[MainController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/updateProfile',[MainController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/addAddress',[MainController::class, 'addAddress'])->name('addAddress');
    Route::get('/addAddress',[MainController::class, 'addAddress'])->name('addAddress');
   
    Route::post('/book',[BookingController::class, 'book'])->name('book');
    Route::get('/book',[BookingController::class, 'book'])->name('book');
    Route::get('/customer/customer_transaction',[BookingController::class, 'customer_transaction'])->name('customer.customer_transaction');
    Route::get('/customer/customer_pay',[BookingController::class, 'customer_pay'])->name('customer.customer_pay');
    Route::get('/customer/customer_history',[BookingController::class, 'customer_history'])->name('customer.customer_history');
    Route::get('/cleaner/cleaner_job',[BookingController::class, 'cleaner_job'])->name('cleaner.cleaner_job');
    Route::get('/cleaner/cleaner_history',[BookingController::class, 'cleaner_history'])->name('cleaner.cleaner_history');
    Route::get('/customer/customer_pay/{id}',[BookingController::class, 'customer_pay'])->name('customer_pay');
    Route::get('/customer/customer_rating/{id}',[BookingController::class, 'customer_rating'])->name('customer_rating');
    Route::post('/newDate',[BookingController::class, 'newDate'])->name('newDate');
    Route::post('/addAddress',[MainController::class, 'addAddress'])->name('addAddress');
    Route::post('/deleteAddress',[MainController::class, 'deleteAddress'])->name('deleteAddress');
    Route::get('/deleteAddress',[MainController::class, 'deleteAddress'])->name('deleteAddress');
    Route::post('/updateAddress',[BookingController::class, 'updateAddress'])->name('updateAddress');

    //Route for Cleaner App
    Route::get('/cleaner/cleaner_login',[MainController::class, 'cleaner_login'])->name('cleaner.cleaner_login');
    Route::get('/cleaner/cleaner_register',[MainController::class, 'cleaner_register'])->name('cleaner.cleaner_register');
    Route::get('/cleaner/cleaner_dashboard',[MainController::class, 'cleaner_dashboard'])->name('cleaner.cleaner_dashboard');
    Route::get('/cleaner/cleaner_profile',[MainController::class, 'cleaner_profile'])->name('cleaner.cleaner_profile');
    Route::get('/updateCleaner',[MainController::class, 'updateCleaner'])->name('updateCleaner');
    Route::post('/updateCleaner',[MainController::class, 'updateCleaner'])->name('updateCleaner');
    Route::get('/cleaner/cleaner_map',[BookingController::class, 'cleaner_map'])->name('cleaner.cleaner_map');
    Route::post('/assignCleaner',[BookingController::class, 'assignCleaner'])->name('assignCleaner');
    Route::post('/checkout',[BookingController::class, 'checkout'])->name('checkout');
    Route::get('/checkout',[BookingController::class, 'checkout'])->name('checkout');
    Route::get('/onsitePayment',[BookingController::class, 'onsitePayment'])->name('onsitePayment');
    Route::post('/onsitePayment',[BookingController::class, 'onsitePayment'])->name('onsitePayment');
    Route::get('/gcash',[BookingController::class, 'gcash'])->name('gcash');
    Route::post('/gcash',[BookingController::class, 'gcash'])->name('gcash');
    Route::post('/paid',[BookingController::class, 'paid'])->name('paid');
    
    //Payment Paypal
    Route::get('paypal/checkout/{booking}', [PayPalController::class, 'getExpressCheckout'])->name('paypal.checkout');
    Route::get('paypal/checkout-success/{booking}', [PayPalController::class, 'getExpressCheckoutSuccess'])->name('paypal.success');
    Route::get('paypal/checkout-cancel', [PayPalController::class, 'cancelPage'])->name('paypal.cancel');

    Route::post('/rate',[BookingController::class, 'rate'])->name('rate');
    Route::get('/rate',[BookingController::class, 'rate'])->name('rate');

    Route::get('/notification',[BookingController::class, 'notification'])->name('notification');
    Route::get('/userNotification/{id}',[BookingController::class, 'userNotification'])->name('userNotification');
    Route::get('/customer/customer_transaction/{id}',[BookingController::class, 'read'])->name('read');
    Route::get('/admin_transaction/{id}',[BookingController::class, 'read'])->name('read');
    Route::get('/cleaner/cleaner_job/{id}',[BookingController::class, 'read'])->name('read');
    Route::get('/cleaner/cleaner_history/{id}',[BookingController::class, 'read'])->name('read');
    Route::get('/admin_transaction_history/{id}',[BookingController::class, 'read'])->name('read');
    Route::get('/customer/customer_history/{id}',[BookingController::class, 'read'])->name('read');

    //Booking Module
    Route::post('/updateStatus',[BookingController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/updateStatus', [BookingController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/cleaner',[BookingController::class, 'cleaner'])->name('cleaner');

    Route::post('/Webhook',[BookingController::class, 'Webhook'])->name('Webhook');

    //Route::get('cleaner/cleaner_dashboard', [FullCalendarController::class, 'getEvents']);

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

    Route::get('/update_account/{id}',[MailSend::class, 'mailsend'])->name('update_account');

    Route::get('/contactUs',[MainController::class, 'contactUs'])->name('contactUs');
    Route::post('/contactUs',[MainController::class, 'contactUs'])->name('contactUs');

    Route::get('/employee/home',[MainController::class, 'home'])->name('employee.home');

    Route::get('/employee',[MainController::class, 'employee'])->name('employee');

    Route::get('/on_the_way',[ServiceController::class, 'on_the_way'])->name('on_the_way'); 
    Route::get('/pending',[ServiceController::class, 'pending'])->name('pending'); 
    Route::get('/accepted',[ServiceController::class, 'accepted'])->name('accepted'); 
    Route::get('/on_progress',[ServiceController::class, 'on_progress'])->name('on_progress'); 
    Route::get('/done',[ServiceController::class, 'done'])->name('done'); 

    //Route for Employee
    Route::get('/employee',[MainController::class, 'employee_login'])->name('employee.login');
    Route::post('/employee_check',[MainController::class, 'employee_check'])->name('employee_check');
    Route::post('/timeIn',[MainController::class, 'timeIn'])->name('timeIn');
    Route::get('/employee/employee_dashboard',[MainController::class, 'employee_dashboard'])->name('employee.employee_dashboard');
    Route::get('/computeSalary',[BookingController::class, 'computeSalary'])->name('computeSalary');
});

Route::get('/cleaner/cleaner_welcome', function () {
    return view('/cleaner/cleaner_welcome');
});

//Route for the Sweep Welcome Page
Route::get('sweep_welcome', function () {
    return view('sweep_welcome');
}); 
Route::get('/services', function () {
    return view('services');
});

Route::get('/jobs', function () {
    return view('jobs');
});

Route::get('/about_us', function () {
    return view('about_us');
});

Route::get('/contact_us', function () {
    return view('contact_us');
});
//Route for the FAQs Page
Route::get('/faqs', function () {
    return view('sweep_faqs');
});

Route::get('/sanitation', function () {
    return view('sanitation');
});
Route::get('/cleaning', function () {
    return view('cleaning');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('test', function () {
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );

    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );
    $messages = 'Okay';
    $id = 4;
    $data = ['messages' => $messages, 'id' => $id];
    $pusher->trigger('my-channel', 'cleaner-refresh', $data);
    return "Event has been sent";
});
