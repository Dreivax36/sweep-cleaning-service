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
            return redirect('/');
        }
        return redirect('/');
    }

    function admin_dashboard(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_dashboard', $data);
    }

    //Customer Pages
    function customer_register(){
        return view('customer.customer_register');
    }

    function customer_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:admins',
            'contact_number'=>'required',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',// Only allow .jpg, .bmp and .png file types.
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
        ]);
            // Save the file locally in the storage/public/ folder under a new folder named /user
            $request->profile_picture->store('user', 'public');
            $request->valid_id->store('user', 'public');
            
           
            //$profile_path = $request->file('profile_picture')->store('public/images');
          //  $id_path = $request->file('valid_id')->store('public/images');

            //Insert data into database
            $users = new User;
            $users->full_name = $request->full_name;
            $users->email = $request->email;
            $users->contact_number = $request->contact_number;
            $users->password = Hash::make($request->password);
            // Store the record, using the new file hashname which will be it's new filename identity.
            $users->profile_picture = $request->profile_picture->hashName();
            $users->account_status = 'To_verify';
            $users->user_type = 'Customer';
            $customer_save = $users->save();

            $id = $users->user_id;

            $identifications = new Identification;
            $identifications->user_id = $id;
            $identifications->valid_id =  $request->valid_id->hashName();
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

    function customer_login(){
        return view('customer.customer_login');
    }
    
    function customer_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_dashboard', $data);
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
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg', // Only allow .jpg, .bmp and .png file types.
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
        ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->profile_picture->store('user', 'public');
            $request->valid_id->store('user', 'public');

            //Insert data into database
            $users = new User;
            $users->full_name = $request->full_name;
            $users->email = $request->email;
            $users->contact_number = $request->contact_number;
            $users->password = Hash::make($request->password);
            $users->profile_picture = $request->profile_picture->hashName();
            $users->account_status = 'To_verify';
            $users->user_type = 'Cleaner';
            $cleaner_save = $users->save();

            $id = $users->user_id;

            $identifications = new Identification;
            $identifications->user_id = $id;
            $identifications->valid_id = $request->valid_id->hashName();
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


}
