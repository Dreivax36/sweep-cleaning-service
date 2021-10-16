<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Admin;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Customer;
use App\Models\Assigned_cleaner;
use App\Models\Event;
use App\Models\Service;
use App\Models\Review;
use App\Models\Service_review;
use App\Models\Cleaner_review;
use App\Post;
use App\Notifications\NotifyUser;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\Payment;
use Pusher\Pusher;

class BookingController extends Controller
{
    function admin_transaction(){
        //Retrieve Services Data from database  
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction', $data);
    }
    
    function customer_transaction(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_transaction', $data);
    }
    function pay(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.pay', $data);
    }
  

    function customer_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_history', $data);
    }

    function cleaner_job(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_job', $data);
    }
    function cleaner_map(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_map', $data);
    }

    function cleaner_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_history', $data);
    }

    function updateStatus(Request $request){
 
        //Update data into database
        $bookingID = $request->booking_id;
        $status = $request->status;
       $updateStatus= Booking::Where('booking_id', $bookingID )->update(['status' => $status]);
    
       $notifications = new Notification();
       $notifications->message = "Status of Transaction $bookingID is $status.";
       $notifications->booking_id = $bookingID;
       $notifications->isRead = false; 
       $notifications->location = 'admin_transaction';
       $updateStatus = $notifications->save();

       $customerid= Booking::Where('booking_id', $request->booking_id )->value('customer_id');
       $user = Customer::Where('customer_id', $customerid)->value('user_id');
       $notifications = new Notification();
       $notifications->message = "Status of Transaction $bookingID is $status.";
       $notifications->booking_id = $bookingID;
       $notifications->isRead = false; 
       $notifications->user_id = $user;
       $notifications->location = 'customer/customer_transaction';
       $updateStatus = $notifications->save();
             
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

        $messages = 'Status Updated';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);
        $pusher->trigger('my-channel', 'customer-notif', $data);

        $id = $user;  
        $data = ['messages' => $messages, 'id' => $id];
        $pusher->trigger('my-channel', 'status', $data);

       $cleaner = Assigned_cleaner::Where('booking_id', $bookingID)->value('cleaner_id');
       foreach($cleaner as $cleanerID){
            $userCleaner = Cleaner::Where('cleaner_id', $cleanerID)->value('user_id');

            $notifications = new Notification();
            $notifications->message = "Status of Transaction $bookingID is $status.";
            $notifications->booking_id = $bookingID;
            $notifications->isRead = false; 
            $notifications->user_id = $userCleaner;
            $notifications->location = 'cleaner/cleaner_job';
            $updateStatus = $notifications->save();

            $messages = 'Status Updated';
            $data = ['messages' => $messages];
            $pusher->trigger('my-channel', 'cleaner-notif', $data);

            $id = $userCleaner;  
            $data = ['messages' => $messages, 'id' => $id];
            $pusher->trigger('my-channel', 'cleaner-status', $data);
       }

       if($status == 'Completed'){
            $updateEvent= Event::Where('booking_id', $request->booking_id )->delete();
       }

       if($updateStatus){
           return back()->with('success', 'Successfully Update the Booking Status');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    function updateAddress(Request $request){
 
        //Update data into database
        $updateAddress= Booking::Where('booking_id', $request->booking_id )->update(['address_id' => $request->address]);

       if($updateAddress){
           return back()->with('success', 'Address Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    
    function cleaner(Request $request){
 
        //Update data into database
        $updateCleaner = Assigned_cleaner::Where('booking_id', '=', $request->booking_id )->Where('cleaner_id', '=', $request->cleaner_id )->update(['status'=> $request->status ] );
        
        $notifications = new Notification();
        $id = Cleaner::where('cleaner_id', $request->cleaner_id)->value('user_id');
        $name = User::where('user_id', $id)->value('full_name');
        $notifications->message = "Cleaner $name update the status of Transaction $request->booking_id.";
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'cleaner/cleaner_job';
        $cleaner = $notifications->save();

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

        $messages = 'Status Updated';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);


        if($updateCleaner){
           return back()->with('success', 'Cleaner Successfully Update the Booking Status');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    function assignCleaner(Request $request){

        foreach($request->input('cleaner_id') AS $cleaner_id){
        $id = Cleaner::Where('user_id', $cleaner_id )->value('cleaner_id');
        $assigned_cleaners = new Assigned_cleaner();
        $assigned_cleaners->booking_id = $request->booking_id;
        $assigned_cleaners->status = $request->status;
        $assigned_cleaners->cleaner_id = $id;
        $assign = $assigned_cleaners->save();

        $notifications = new Notification();
        $notifications->user_id = $cleaner_id;
        $notifications->message = 'New Job';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'cleaner/cleaner_job';
        $assign = $notifications->save();

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

        $messages = 'Status Updated';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'cleaner-notif', $data);


        }
       if($assign){
           return back()->with('success-assign', 'Successfully Assigned Cleaner');
        }
        else {
          return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function book(Request $request){
        
        //Validate Requests
        $request->validate([
            'property_type'=>'required',

        ]);
        
        $id = Customer::Where('user_id', $request->user_id )->value('customer_id');
        $address = Address::Where('customer_id', $id )->value('address_id');
        $bookings = new Booking();
        $bookings->service_id = $request->service_id;
        $bookings->customer_id = $id;
        $bookings->property_type = $request->property_type;
        $bookings->schedule_date = $request->schedule_date;
        $bookings->schedule_time = $request->schedule_time;
        $bookings->mode_of_payment = $request->mode_of_payment;
        $bookings->status = 'Pending';
        $bookings->is_paid = false;
        $bookings->address_id = $address;
        $book = $bookings->save();

        $date = $request->schedule_date;
        $time = $request->schedule_time;        
        $startdate = $date . ' ' . $time;

        $events = new Event();
        $title = Service::Where('service_id', $request->service_id )->value('service_name');
        $events->title = $title;
        $events->start = $startdate;

        $time = Carbon::parse($startdate);
        $enddate = $time->addHours(2);

        $events->end = $enddate;
        $events->booking_id = $bookings->booking_id;
        $book = $events->save();

        $notifications = new Notification();
        $notifications->message = 'New Booking';
        $notifications->booking_id = $bookings->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        
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
        $messages = 'New Booking';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);

        if($book){
            return back()->with('success', 'New Booking has been successfuly created');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function customer_pay(Request $request){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_checkout', $data)->with('booking_id', $request->route('id'));
       // return redirect()->route('paypal.checkout', $request->route('id'));
       // $updatePayment= Booking::Where('booking_id', $request->booking_id )->update(['mode_of_payment' => $request->mode_of_payment]);
    }

    function customer_rating(Request $request){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_rating', $data)->with('booking_id', $request->route('id'));
    }

    function rate(Request $request){
        $reviews = new Review();
        $reviews->review_type = 'Service';
        $reviews->booking_id = $request->booking_id;
        $rate = $reviews->save();

        $id = $reviews->review_id;

        $service_reviews = new Service_review();
        $service_reviews->service_id = $request->service_id;
        $service_reviews->comment = $request->service_comment;
        $service_reviews->rate = $request->service_rate;
        $service_reviews->review_id = $id;
        $rate = $service_reviews->save();

        
        foreach($request->input('cleaner_id') AS $cleaner_id){
            
            $reviews = new Review();
            $reviews->review_type = 'Cleaner';
            $reviews->booking_id = $request->booking_id;
            $rate = $reviews->save(); 

            $id = $reviews->review_id;
            $cleaner_reviews = new Cleaner_review();
            $cleaner_reviews->cleaner_id = $cleaner_id;
            $cleaner_reviews->comment = $request->cleaner_comment;
            $cleaner_reviews->rate = $request->cleaner_rate;
            $cleaner_reviews->review_id = $id;
            $rate = $cleaner_reviews->save();

        }

        $notifications = new Notification();
        $notifications->message = 'Customer submit reviews';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        
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
        $messages = 'New Booking';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);

        return redirect()->route('customer.customer_transaction')->with('success-rate', 'Rate Successful');
    }

    function checkout(Request $request){
        
        $payments = new Payment();
        $payments->booking_id = $_GET['booking_id'];
        $payments->amount = $_GET['amount']; 
        $checkout = $payments->save();

        $checkout= Booking::Where('booking_id', $_GET['booking_id'] )->update(['is_paid' => true, 'paypal_id' => $_GET['paypal_id']]);
      
        $notifications = new Notification();
        $notifications->message = 'Customer paid';
        $notifications->booking_id = $_GET['booking_id'];
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        
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
        $messages = 'New Booking';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);


        if($checkout){
           return redirect()->route('customer.customer_transaction')->with('success-pay', 'Payment Successful');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function onsite_payment(Request $request){
        
        $payments = new Payment();
        $payments->booking_id = $request->booking_id;
        $payments->amount = $request->amount; 
        $checkout = $payments->save();

        $checkout= Booking::Where('booking_id', $_GET['booking_id'] )->update(['is_paid' => true]);
      
        $notifications = new Notification();
        $notifications->message = 'Customer pay to the cleaner';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        
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
        $messages = 'New Booking';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);


        if($checkout){
           return back()->with('success-cleaner', 'Payment Successful');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function newDate(Request $request){
        
        $newDate= Booking::Where('booking_id', $request->booking_id )->update(['schedule_date' => $request->schedule_date, 'schedule_time' => $request->schedule_time ]);

        $notifications = new Notification();
        $notifications->message = 'Customer choose new schedule';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        
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
        $messages = 'New Booking';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);

        if($newDate){
           return back()->with('success', 'Date is successfuly updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }


    function read(Request $request){
        $notif = Notification::where('id', $request->route('id'))->update(['isRead' => true]);
        $location = Notification::where('id', $request->route('id'))->value('location');
        if($notif){
            return redirect()->route($location);
         }
         else {
             return back()->with('fail','Something went wrong, try again later ');
         }
    }

    function notification(Request $request){
        $notif = Notification::where('isRead', false)->orderBy('id', 'DESC')->get();
        return view('notification', ['notif' => $notif]); 
    }
    function userNotification(Request $request){
        $notif = Notification::where('isRead', false)->where('user_id',$request->route('id') )->orderBy('id', 'DESC')->get();
        return view('notification', ['notif' => $notif]); 
    }
}