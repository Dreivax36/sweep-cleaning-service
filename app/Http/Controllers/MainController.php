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
use App\Models\Notification;
use App\Mail\SendMail;
class MainController extends Controller
{
    //View Landing Page
    function sweep_welcome(){
        return view('sweep_welcome');
    }
    function login(){
        return view('auth.login');
    }
    function register(){
        return view('auth.register');
    }
    //Create admin account
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
            return back()->with('success', 'New Admin User has been successfully added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Verify Admin Login
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
                $request->session()->put('LoggedUser', $userInfo->admin_id);
                return redirect('/admin_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }
    //Logout of Admin and Customer
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/');
        }
        return redirect('/');
    }
    //View Admin Dashboard Page
    function admin_dashboard(){
        //Get the data of user logged in
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_dashboard', $data);
    }
    //View Admin User Page
    function admin_user(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user', $data);
    }
    //View Admin User Customer Page
    function admin_user_customer(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user_customer', $data);
    }
    //View Admin User Cleaner Page
    function admin_user_cleaner(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user_cleaner', $data);
    }
    //View Admin Payroll Page
    function admin_payroll(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_payroll', $data);
    }

    /*function admin_payroll_employee(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_payroll_employee', $data);
    }
    function admin_payroll_cleaner(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_payroll_cleaner', $data);
    }*/
    //Customer registration page
    function customer_register(){
        return view('customer.customer_register');
    }
    //Register customer account
    function customer_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',// Only allow .jpg, .bmp and .png file types.
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
        ]);
           // Save the file in the /public/ folder under a new folder named /images
           $profile = time().'.'.$request->profile_picture->extension();
           $request->profile_picture->move(public_path('images'),$profile);
           
           //Insert data into database
           //Insert to user table
           $users = new User;
           $users->full_name = $request->full_name;
           $users->email = $request->email;
           $users->contact_number = $request->contact_number;
           $users->password = Hash::make($request->password);
           // Store the record, using the new file hashname which will be it's new filename identity.
           $users->profile_picture = $profile;
           $users->account_status = 'To_validate';
           $users->user_type = 'Customer';
           $customer_save = $users->save();
           $id = $users->user_id;

           // Save the file in the /public/ folder under a new folder named /images
           $validID = time().'.'.$request->valid_id->extension();
           $request->valid_id->move(public_path('images'),$validID);

           //Insert to Identification table
           $identifications = new Identification;
           $identifications->user_id = $id;
           $identifications->valid_id =  $validID;
           $customer_save = $identifications->save();
          
           //Insert to Customer table
           $customers = new Customer;
           $customers->user_id = $id;
           $customer_save = $customers->save();

           //Insert to Address table
           $id = $customers->customer_id;
           $addresses = new Address;
           $addresses->address = $request->address;
           $addresses->customer_id = $id;
           $customer_save = $addresses->save();
        
           //Send email to verify the email address
           $id = $users->user_id;
           $email = $users->email;
           $name = $users->full_name;
    
           $details = [
            'title' => 'Mail from Sweep Cleaning Service',
            'user_id' => $id ,
            'user_type' => 'Customer',
            'name' => $name,
            ];

            \Mail::to($email)->send(new \App\Mail\SendMail($details));

        if($customer_save){
            return back()->with('success', 'Successfully created an account. Please check your email to verify it.');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Update Customer user table that email address is verified
    function verify(Request $request){
        $verify = User::Where('user_id', $request->route('id') )->update(['email_verified_at' => now()]);
        
        if($verify){
            return redirect('customer/customer_login')->with('success', 'Email Verified');
        }
        else {
            return redirect('customer/customer_login')->with('fail','Something went wrong, try again later ');
        }
    }
    //Customer login page
    function customer_login(){
        return view('customer.customer_login');
    }
    //Customer login validation
    function customer_check(Request $request){
        //Validate requests
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);
        //Check if the email inputted exist in user table, user is a customer and email verified
        $userInfo = User::where('email','=', $request->email)->where('user_type','=', 'Customer')->where('email_verified_at','!=', null)->first();
        $email =  User::where('email','=', $request->email)->get();
        $verified =  User::where('email_verified_at','!=', null)->get();

        if(!$userInfo){
            if($email == null){
                return back()->with('fail', 'Your email address is not verified');
            }elseif($verified == null){
                return back()->with('fail', 'Please verified your email first.');
            }else{
                return back()->with('fail', 'We do not recognize your email address');
            }
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

    //Customer update information 
    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'address'=>'required',
        ]);
        //Update User table
        $update= User::Where('user_id', $request->user_id )->update(['full_name' => $request->full_name, 'email' => $request->email,'contact_number' => $request->contact_number]);
        //Update Address table
        $count = 0;  
        foreach($request->input('address_id') AS $address_id){
            $address = $request->input('address')[$count];
            $update= Address::Where('address_id', $address_id )->update(['address' => $address]);
            $count++;
        }
       
        if($update){   
            return back()->with('success', 'You successfully updated your profile');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Customer add new address
    function addAddress(Request $request){
        $request->validate([
            'address'=>'required',
        ]);
        //insert to address table
        $addresses = new Address();
        $addresses->customer_id = $request->customer_id;
        $addresses->address = $request->address;
        $addAddress = $addresses->save();
 
        if($addAddress){
            return back()->with('success-add', 'Address successfully added');
         }
         else {
             return back()->with('fail','Something went wrong, try again later ');
         }
     }
     //Customer delete address
     function deleteAddress(Request $request){
        $deleteAddress = Address::Where('address_id', $request->address_id)->delete();

        if($deleteAddress){
            return back()->with('success-delete', 'Address successfully deleted');
         }
         else {
             return back()->with('fail','Something went wrong, try again later ');
         }
    }
    //Customer dashboard page
    function customer_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_dashboard', $data);
    }
    //Customer profile page
    function customer_profile(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_profile', $data);
    }


    //Cleaner registration page
    function cleaner_register(){
        return view('cleaner.cleaner_register');
    }
    //Register cleaner account
    function cleaner_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg', // Only allow .jpg, .gif, .svg and .png file types.
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'description'=>'required',
            'requirement' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'age' => 'required|numeric',
        ]);

             // Save the file in the /public/ folder under a new folder named /images
             $profile = time().'.'.$request->profile_picture->extension();
             $request->profile_picture->move(public_path('images'),$profile);
             
 
             //Insert data into database
             $users = new User;
             $users->full_name = $request->full_name;
             $users->email = $request->email;
             $users->contact_number = $request->contact_number;
             $users->password = Hash::make($request->password);
             $users->profile_picture = $profile;
             $users->account_status = 'To_validate';
             $users->user_type = 'Cleaner';
             $cleaner_save = $users->save();
 
             $id = $users->user_id;
             // Save the file in the /public/ folder under a new folder named /images
             $validId = time().'.'.$request->valid_id->extension();
             $request->valid_id->move(public_path('images'),$validId);

             //Insert to identification table
             $identifications = new Identification;
             $identifications->user_id = $id;
             $identifications->valid_id = $validId;
             $customer_save = $identifications->save();
            //Insert to cleaner table
             $cleaners = new Cleaner;
             $cleaners->user_id = $id;
             $cleaners->age = $request->age;
             $cleaners->address = $request->address;
             $cleaner_save = $cleaners->save();
             // Save the file in the /public/ folder under a new folder named /images
             $require = time().'.'.$request->requirement->extension();
             $request->requirement->move(public_path('images'),$require);
             $id = $cleaners->cleaner_id;
             //Insert to clearance table
             $clearances = new Clearance;
             $clearances->cleaner_id = $id;
             $clearances->requirement = $require;
             $clearances->description = $request->description;
             $cleaner_save = $clearances->save();

            //Send email to verify the email address
            $id = $users->user_id;
            $email = $users->email;
            $name = $users->full_name;
            $details = [
             'title' => 'Mail from Sweep Cleaning Service',
             'user_id' => $id ,
             'user_type' => 'Cleaner',
             'name' => $name,
            ];
            \Mail::to($email)->send(new \App\Mail\SendMail($details));

            if($cleaner_save){
                return back()->with('success', 'Successfully created an account. Please check your email to verify it.');
            }
            else {
                return back()->with('fail','Something went wrong, try again later ');
            }
    }
    //Update Cleaner user table that email address is verified
    function verify_cleaner(Request $request){
        $verify = User::Where('user_id', $request->route('id') )->update(['email_verified_at' => now()]);
        
        if($verify){
            return redirect('customer/customer_login')->with('success', 'Email Verified');
        }
        else {
            return redirect('customer/customer_login')->with('fail','Something went wrong, try again later ');
        }
    }
    //Cleaner login page
    function cleaner_login(){
        return view('cleaner.cleaner_login');
    }
    //Cleaner login validation
    function cleaner_check(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);
        //Check if the email inputted exist in user table, user type is cleaner and email verified 
        $userInfo = User::where('email','=', $request->email)->where('user_type','=', 'Cleaner')->where('email_verified_at','!=', null)->first();
        $email =  User::where('email','=', $request->email)->get();
        $verified =  User::where('email_verified_at','!=', null)->get();

        if(!$userInfo){
            if($email == null){
                return back()->with('fail', 'Your email address is not verified');
            }
            elseif($verified == null){
                return back()->with('fail', 'Please verified your email first.');
            }else{
                return back()->with('fail', 'We do not recognize your email address');
            }
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
    //Cleaner dashboard page
    function cleaner_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_dashboard', $data);
    }
    //Cleaner Profile
    function cleaner_profile(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_profile', $data);
    }
    //Cleaner update information
    public function updateCleaner(Request $request)
    {
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'address'=>'required',
            'age'=>'required|numeric',
        ]);
        //Update user table
        $update= User::Where('user_id', $request->user_id )->update(['full_name' => $request->full_name, 'email' => $request->email,'contact_number' => $request->contact_number]);
        //Update cleaner table
        $update= Cleaner::Where('user_id', $request->user_id )->update(['address' => $request->address, 'age' => $request->age]);

        if($update){   
            return back()->with('success', 'Profile successfully Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    //Cleaner logout
    function logout_cleaner(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/cleaner/cleaner_welcome');
        }
        return redirect('/cleaner/cleaner_welcome');
    }

}
