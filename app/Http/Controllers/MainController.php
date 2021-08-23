<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin; 
use App\Models\Price;
use App\Models\Service;
use App\Models\User;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Cleaner;
use App\Models\Clearance;
use App\Models\Identification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    //Admin Pages
    function sweep_welcome(){
        return view('sweep_welcome');
    }
    function login(){
        return view('auth.login');
    }
    function register(){
        return view('auth.register');
    }
    function save(Request $request){
        
        //Validate Requests
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:5|max:12'
        ]);

        //Insert data into database
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $save = $admin->save();

        if($save){
            return back()->with('success', 'New User has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function check(Request $request){
        //Validate requests
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);

        $userInfo = Admin::where('email','=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail', 'We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                return redirect('/admin_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }
    
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/auth/login');
        }
        return redirect('/auth/login');
    }

    function admin_dashboard(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_dashboard', $data);
    }

    function addService(Request $request){
        
        //Validate Requests
        $request->validate([
            'service_name'=>'required',
            'description'=>'required',
            'equipment'=>'required',
            'material'=>'required',
            'personal_protection'=>'required',
            'resident_number_of_cleaner'=>'required',
            'apartment_number_of_cleaner'=>'required',
            'condo_number_of_cleaner'=>'required',
            'resident_price'=>'required',
            'apartment_price'=>'required',
            'condo_price'=>'required'
        ]);

        //Insert data into database
        $services = new Service();
        $services->service_name = $request->service_name;
        $services->service_description = $request->description;
        $services->equipment = $request->equipment;
        $services->material = $request->material;
        $services->personal_protection = $request->personal_protection;
        $addService = $services->save();

        $id = $services->service_id;

        $prices = new Price();
        $prices->property_type = 'Medium-Upper Class Residential Areas';
        $prices->price = $request->resident_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->resident_number_of_cleaner;
        $addService = $prices->save();
        $prices = new Price();
        $prices->property_type = 'Apartments';
        $prices->price = $request->apartment_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->apartment_number_of_cleaner;
        $addService = $prices->save();
        $prices = new Price();
        $prices->property_type = 'Condominiums';
        $prices->price = $request->condo_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->condo_number_of_cleaner;
        $addService = $prices->save();

        if($addService){
            return back()->with('success', 'New Service has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function admin_service(){
        //Retrieve Services Data from database  
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_services', $data);
    }
    function admin_transaction(){
        //Retrieve Services Data from database  
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction', $data);
    }
    function updateStatus(Request $request){
 
        //Update data into database
        //$comp_ids = implode(' ,',(array)$request->get('full_name')); 
        $id = User::Where('full_name', $request->full_name)->value('user_id');
        $user = Cleaner::Where('user_id', $id)->value('cleaner_id');
        $updateStatus= Booking::Where('service_id', $request->service_id )->update(['status' => $request->status, 'cleaner_id' => '1'] );
        
        if($updateStatus){
            return back()->with('success', 'Booking Status Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    //Customer Pages
    function customer_login(){
        return view('customer.customer_login');
    }
    function customer_register(){
        return view('customer.customer_register');
    }
    function customer_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_dashboard', $data);
    }
    function customer_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:admins',
            'contact_number'=>'required',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture'=>'required',
        ]);

        //Insert data into database
        $users = new User;
        $users->full_name = $request->full_name;
        $users->email = $request->email;
        $users->contact_number = $request->contact_number;
        $users->password = Hash::make($request->password);
        $users->profile_picture = $request->profile_picture;
        $users->account_status = 'to_verify';
        $users->user_type = 'Customer';
        $customer_save = $users->save();

        $id = $users->user_id;

        $identifications = new Identification;
        $identifications->user_id = $id;
        $identifications->valid_id =  $request->valid_id;
        $customer_save = $identifications->save();

        $customers = new Customer;
        $customers->user_id = $id;
        $customer_save = $customers->save();



        $id = $customers->customer_id;
        $addresses = new Address;
        $addresses->address = $request->address;
        $addresses->customer_id = $id;
        $customer_save = $addresses->save();

        if($customer_save){
            return back()->with('success', 'New User has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function customer_check(Request $request){
        //Validate requests
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);

        $userInfo = User::where('email','=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail', 'We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->user_id);
                return redirect('customer/customer_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    function customer_services(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_services', $data);
    }

    function book(Request $request){
        
        //Validate Requests
        $request->validate([
            'property_type'=>'required',
            'schedule_date'=>'required',
            'schedule_time'=>'required',
        ]);

        $id = Customer::Where('user_id', $request->user_id )->value('customer_id');

        $bookings = new Booking();
        $bookings->service_id = $request->service_id;
        $bookings->customer_id = $id;
        $bookings->property_type = $request->property_type;
        $bookings->schedule_date = $request->schedule_date;
        $bookings->schedule_time = $request->schedule_time;
        $bookings->status = 'Pending';
        $bookings->is_paid = false;
        $book = $bookings->save();
        

        if($book){
            return back()->with('success', 'New Service has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function customer_transaction(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_transaction', $data);
    }

    function customer_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_history', $data);
    }

    function customer_profile(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_profile', $data);
    }


    //Cleaner Pages
    function cleaner_login(){
        return view('cleaner.cleaner_login');
    }
    function cleaner_register(){
        return view('cleaner.cleaner_register');
    }
    function cleaner_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_dashboard', $data);
    }
    function cleaner_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:admins',
            'contact_number'=>'required',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture'=>'required',
        ]);

        //Insert data into database
        $users = new User;
        $users->full_name = $request->full_name;
        $users->email = $request->email;
        $users->contact_number = $request->contact_number;
        $users->password = Hash::make($request->password);
        $users->profile_picture = $request->profile_picture;
        $users->account_status = 'to_verify';
        $users->user_type = 'Cleaner';
        $cleaner_save = $users->save();

        $id = $users->user_id;

        $identifications = new Identification;
        $identifications->user_id = $id;
        $identifications->valid_id =  $request->valid_id;
        $customer_save = $identifications->save();

        $cleaners = new Cleaner;
        $cleaners->user_id = $id;
        $cleaners->age = $request->age;
        $cleaners->address = $request->address;
        $cleaner_save = $cleaners->save();

        $id = $cleaners->cleaner_id;
        $clearances = new Clearance;
        $clearances->cleaner_id = $id;
        $clearances->requirement = $request->requirement;
        $clearances->description = $request->description;
        $cleaner_save = $clearances->save();

        if($cleaner_save){
            return back()->with('success', 'New User has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function cleaner_check(Request $request){
        //Validate requests
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);

        $userInfo = User::where('email','=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail', 'We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->user_id);
                return redirect('cleaner/cleaner_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    function cleaner_job(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_job', $data);
    }
    function cleaner_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_history', $data);
    }

}
