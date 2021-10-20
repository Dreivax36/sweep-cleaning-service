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
use App\Models\Address;
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
    //View admin transaction page
    function admin_transaction(){
        //Retrieve Services Data from database  
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction', $data);
    }
    //View customer transaction page
    function customer_transaction(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_transaction', $data);
    }
    //View customer history page
    function customer_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_history', $data);
    }
    //View cleaner job page
    function cleaner_job(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_job', $data);
    }
    //View cleaner history page
    function cleaner_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_history', $data);
    }

    //Customer Book a service
    function book(Request $request){
        
        //Validate Requests
        $request->validate([
            'property_type'=>'required',
            'mode_of_payment'=>'required',
            'schedule_date'=>'required',
            'schedule_time'=>'required',
        ]);
        //Add new booking 
        $id = Customer::Where('user_id', $request->user_id )->value('customer_id');
        $address = Address::Where('customer_id', $id )->orderBy('address_id', 'ASC')->first();
        $bookings = new Booking();
        $bookings->service_id = $request->service_id;
        $bookings->customer_id = $id;
        $bookings->property_type = $request->property_type;
        $bookings->schedule_date = $request->schedule_date;
        $bookings->schedule_time = $request->schedule_time;
        $bookings->mode_of_payment = $request->mode_of_payment;
        $bookings->status = 'Pending';
        $bookings->is_paid = false;
        $bookings->address_id = $address['address_id'];
        $book = $bookings->save();

        $id = $bookings->booking_id;
        //Combine the date and time to get the startdate for the event
        $date = $request->schedule_date;
        $time = $request->schedule_time;        
        $startdate = $date . ' ' . $time;
        //Add new event 
        $events = new Event();
        $title = Service::Where('service_id', $request->service_id )->value('service_name');
        $events->title = $title;
        $events->start = $startdate;
        //Add 2 hours to get the enddate for the event
        $time = Carbon::parse($startdate);
        $enddate = $time->addHours(2);
        $events->end = $enddate;
        $events->booking_id = $bookings->booking_id;
        $book = $events->save();
        //Add admin notification
        $notifications = new Notification();
        $notifications->message = 'New Booking';
        $notifications->booking_id = $id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        //Trigger pusher channel to notify the admin
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

    //Assign cleaner
    function assignCleaner(Request $request){
        
        foreach($request->input('cleaner_id') AS $cleaner_id){
            //Insert data to assigned_cleaner table    
            $cleaner = $cleaner_id;   
            $booking = $request->booking_id;
            $id = Cleaner::Where('user_id', $cleaner )->value('cleaner_id');
            $assigned_cleaners = new Assigned_cleaner();
            $assigned_cleaners->booking_id =  $booking;
            $assigned_cleaners->status = $request->status;
            $assigned_cleaners->cleaner_id = $id;
            $assign = $assigned_cleaners->save();
            //Add Cleaner Notification
            $notifications = new Notification();
            $notifications->user_id = $cleaner;
            $notifications->message = 'New Job';
            $notifications->booking_id =  $booking;
            $notifications->isRead = false;
            $notifications->location = 'cleaner/cleaner_job';
            $assign = $notifications->save();
            //Trigger pusher channel to notify the cleaner
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
            $id = $cleaner;
            $data = ['messages' => $messages, 'id' => $id];
            $pusher->trigger('my-channel', 'cleaner-notif', $data);
        }

       if($assign){
           return back()->with('success-assign', 'Successfully Assigned Cleaner');
        }
        else {
          return back()->with('fail','Something went wrong, try again later ');
        }
    }
    
    //Update the transaction status or the book table
    function updateStatus(Request $request){
 
        //Update transaction status
        $bookingID = $request->booking_id;
        $status = $request->status;
        $updateStatus= Booking::Where('booking_id', $bookingID )->update(['status' => $status]);

        //Add Admin notification
        $notifications = new Notification();
        $notifications->message = "Status of Transaction $bookingID is $status.";
        $notifications->booking_id = $bookingID;
        $notifications->isRead = false; 
        if($status == 'Completed' || $status == 'Declined' || $status == 'Cancelled'){
            $notifications->location = 'admin_transaction_history';
        }else{
            $notifications->location = 'admin_transaction';
        }
        $updateStatus = $notifications->save();

        //Trigger pusher channel to notify the admin
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

        //Add Customer notification
        $customerid= Booking::Where('booking_id', $bookingID )->value('customer_id');
        $user = Customer::Where('customer_id', $customerid)->value('user_id');
        $notifications = new Notification();
        $notifications->message = "Status of Transaction $bookingID is $status.";
        $notifications->booking_id = $bookingID;
        $notifications->isRead = false; 
        $notifications->user_id = $user;
        if($status == 'Completed' || $status == 'Declined' || $status == 'Cancelled'){
            $notifications->location = 'customer/customer_history';
        }else{
            $notifications->location = 'customer/customer_transaction';
        }
        $updateStatus = $notifications->save();
             
        //Trigger pusher channel to notify the customer
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
        $id = $user;
        $data = ['messages' => $messages, 'id' => $id];    
        $pusher->trigger('my-channel', 'customer-notif', $data);

        //Retrive all the cleaner assigned in that transaction
        $cleaner = Assigned_cleaner::Where('booking_id', $bookingID)->get();
        if($cleaner != null){
        foreach($cleaner as $cleanerID){
            //Update the status of asssigned_cleaner table 
            if($status == 'Completed' || $status == 'Declined' || $status == 'Cancelled'){
                $assign= Assigned_cleaner::Where('booking_id', '=', $bookingID )->Where('cleaner_id', '=', $cleanerID->cleaner_id )->update(['status'=> $status ] );
            }
             //Add Cleaner Notification
            $userCleaner = Cleaner::Where('cleaner_id', $cleanerID->cleaner_id)->value('user_id');
            $notifications = new Notification();
            $notifications->message = "Status of Transaction $bookingID is $status.";
            $notifications->booking_id = $bookingID;
            $notifications->isRead = false; 
            $notifications->user_id = $userCleaner;
            if($status == 'Completed' || $status == 'Declined' || $status == 'Cancelled'){
                $notifications->location = 'cleaner/cleaner_history';
            }else{
                $notifications->location = 'cleaner/cleaner_job';
            }
            $updateStatus = $notifications->save();

            //Trigger pusher channel to notify the cleaner
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
            $id = $userCleaner;
            $data = ['messages' => $messages, 'id' => $id];
            $pusher->trigger('my-channel', 'cleaner-notif', $data);
        }
    }
        //Delete event when transaction status completed or declined or cancelled
       if($status == 'Completed' || $status == 'Declined' || $status == 'Cancelled'){
            $updateEvent= Event::Where('booking_id', $request->booking_id )->delete();
       }
      
       if($updateStatus){
            if($status == 'Declined' || $status == 'Cancelled'){
                return back()->with('success-decline', 'Successfully Update the Booking Status');
            }
            else{
                return back()->with('success', 'Successfully Update the Booking Status');
            }
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    //Change the customer address in the booking
    function updateAddress(Request $request){
        //Update data into database
        $updateAddress= Booking::Where('booking_id', $request->booking_id )->update(['address_id' => $request->address]);

       if($updateAddress){
           return back()->with('success-address', 'Address Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    
    //Cleaner updated the status of Assigned_cleaner table
    function cleaner(Request $request){
        //Update status
        $status = $request->status;
        $updateCleaner = Assigned_cleaner::Where('booking_id', '=', $request->booking_id )->Where('cleaner_id', '=', $request->cleaner_id )->update(['status'=> $status ] );
        //Add Admin Notification
        $notifications = new Notification();
        $id = Cleaner::where('cleaner_id', $request->cleaner_id)->value('user_id');
        $name = User::where('user_id', $id)->value('full_name');
        $notifications->message = "Cleaner $name update the status of Transaction $request->booking_id.";
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $cleaner = $notifications->save();

        //Trigger pusher channel to notify the admin
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
        $messages = 'Cleaner Status Updated';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);

        if($updateCleaner){
            if($status == 'Declined'){
                return back()->with('success-decline', 'Cleaner Successfully Update the Booking Status');
            }
            else {
                return back()->with('success', 'Cleaner Successfully Update the Booking Status');
            }
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

    //View customer rating page
    function customer_rating(Request $request){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_rating', $data)->with('booking_id', $request->route('id'));
    }
    //Customer rate the service and cleaner/s
    function rate(Request $request){
        //Insert the booking_id and review_type Service to review table
        $booking = $request->booking_id;
        $reviews = new Review();
        $reviews->review_type = 'Service';
        $reviews->booking_id = $booking;
        $rate = $reviews->save();
        //Add the new service rating to service_review table
        $id = $reviews->review_id;
        $service_reviews = new Service_review();
        $service_reviews->service_id = $request->service_id;
        $service_reviews->comment = $request->service_comment;
        $service_reviews->rate = $request->service_rate;
        $service_reviews->review_id = $id;
        $rate = $service_reviews->save();

        //Get the comments and store to temporary array variable
        $comment = array();
        $rate = array();
        $countRate= 0;
        $countComment= 0;
        foreach($request->input('cleaner_comment') AS $cleaner_comment){
            $comment[$countComment++] = $cleaner_comment;
        }
        
        $counter = 0;
        foreach($request->input('cleaner_id') AS $cleaner_id){
            //Insert the booking_id and review_type Cleaner to review table
            $reviews = new Review();
            $reviews->review_type = 'Cleaner';
            $reviews->booking_id = $booking;
            $rate = $reviews->save(); 
            $id = $reviews->review_id;   
            //Add the new cleaner/s rating to cleaner_review table
            $cleaner_reviews = new Cleaner_review();
            $cleaner_reviews->cleaner_id = $cleaner_id;
            $cleaner_reviews->comment = $comment[$counter];
            $cleaner_reviews->rate = $request->cleaner_rate[$counter];
            $cleaner_reviews->review_id = $id;
            $rate = $cleaner_reviews->save();
            $counter++;
        }
        //Add admin notification
        $notifications = new Notification();
        $notifications->message = 'Customer submit reviews';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        //Trigger pusher channel to notify the admin
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

        return redirect('customer/customer_transaction')->with('success-rate', 'Rate Successful');
    }
    //Paypal payment and store the data to payment table
    function checkout(Request $request){
        //Add new payment
        $payments = new Payment();
        $payments->booking_id = $request->booking_id;
        $payments->amount = $request->amount;
        $checkout = $payments->save();
        //Update the booking table
        $checkout= Booking::Where('booking_id', $request->booking_id )->update(['is_paid' => true, 'paypal_id' => $request->paypal_id]);
        //Add admin notification
        $notifications = new Notification();
        $notifications->message = 'Payment Confirmed';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'customer/customer_transaction';
        $assign = $notifications->save();

        //Trigger pusher channel to notify the admin
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
        $user = Booking::Where('booking_id', $request->booking_id )->value('customer_id');
        $messages = 'Payment';
        $id = $user;
        $data = ['messages' => $messages, 'id' => $id];    
        $pusher->trigger('my-channel', 'customer-notif', $data);

        if($checkout){
           return redirect('customer/customer_transaction')->with('success-pay', 'Payment Successful');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Onsite Payment - Cleaner update the payment of the customer
    function onsitePayment(Request $request){
        //Add new payment
        $booking = $request->booking_id;
        $payments = new Payment();
        $payments->booking_id = $booking;
        $payments->amount = $request->amount; 
        $onsitePayment = $payments->save();
        //Update the booking table
        $onsitePayment= Booking::Where('booking_id', $booking )->update(['is_paid' => true]);
        //Add admin notification
        $notifications = new Notification();
        $notifications->message = 'Customer pay to the cleaner';
        $notifications->booking_id = $booking;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $onsitePayment = $notifications->save();

        //Trigger pusher channel to notify the admin
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

        if($onsitePayment){
           return back()->with('success-cleaner', 'Payment Successful');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Customer Update new schedule date and time
    function newDate(Request $request){
        //Update booking table
        $newDate= Booking::Where('booking_id', $request->booking_id )->update(['schedule_date' => $request->schedule_date, 'schedule_time' => $request->schedule_time, 'status' => 'Pending' ]);
        //Add admin notification
        $notifications = new Notification();
        $notifications->message = 'Customer choose new schedule';
        $notifications->booking_id = $request->booking_id;
        $notifications->isRead = false;
        $notifications->location = 'admin_transaction';
        $assign = $notifications->save();

        //Trigger pusher channel to notify the admin
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
        $messages = 'New Date';
        $data = ['messages' => $messages];
        $pusher->trigger('my-channel', 'admin-notif', $data);

        if($newDate){
           return back()->with('success', 'Date is successfuly updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Read Notification
    function read(Request $request){
        //Update notification isRead to true
        $notif = Notification::where('id', $request->route('id'))->update(['isRead' => true]);
        $location = Notification::where('id', $request->route('id'))->value('location');

        if($notif){
            return redirect($location);
         }
         else {
             return back()->with('fail','Something went wrong, try again later ');
         }
    }

}