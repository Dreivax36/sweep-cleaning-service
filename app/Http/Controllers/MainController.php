<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin; 
use App\Models\Employee; 
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
use Illuminate\Support\Str;
use App\Models\Time_entry;

class MainController extends Controller
{
    //View landing page
    function sweep_welcome(){
        return view('sweep_welcome');
    }
    function login(){
        return view('auth.login');
    }
    
    //Verify Admin's login attempt
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
            //Check Admin's password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->admin_id);
                return redirect('/admin_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    //Customer and Admin logout
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/');
        }
        return redirect('/');
    }

    //View Admin dashboard page
    function admin_dashboard(){
        //Get the data of logged in user
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_dashboard', $data);
    }

    //View all the User page
    function admin_user(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user', $data);
    }

    //View all the Customer page
    function admin_user_customer(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user_customer', $data);
    }

    //View all the Cleaner page
    function admin_user_cleaner(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user_cleaner', $data);
    }

    //View all the Employee page
    function admin_user_employees(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_user_employees', $data);
    }

    //View all the relevant business reports
    function admin_reports(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_reports', $data);
    }

    //View the payroll of all the employee
    function admin_payroll_employee(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_payroll_employee', $data);
    }

    //View the payroll of all the cleaner
    function admin_payroll_cleaner(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_payroll_cleaner', $data);
    }

    //Customer registration page
    function customer_register(){
        return view('customer.customer_register');
    }

    function customer_register_step2(Request $request){
        return view('customer.customer_register_step2')->with('user_id', $request->route('id'));
    }

    //Submit the initial Customer registration 
    function customer_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg', // Only allow .jpg, .bmp and .png file types.
        ]);
           //Save the file in the /public/ folder under a new folder named /images
           $profile = time().'.'.$request->profile_picture->extension();
           $request->profile_picture->move(public_path('images'),$profile);
           
           //Insert data into database
           //Insert to user table
           $users = new User;
           $users->full_name = $request->full_name;
           $users->email = $request->email;
           $users->contact_number = $request->contact_number;
           $users->password = Hash::make($request->password);
           //Store the record, using the new file hashname which will be its new filename identity.
           $users->profile_picture = $profile;
           $users->account_status = 'To_validate';
           $users->user_type = 'Customer';
           $usersave = $users->save();
           $id = $users->user_id;
          
           //Insert to customer table
           $customers = new Customer;
           $customers->user_id = $id;
           $customer_save = $customers->save();

           //Insert to address table
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
            return redirect('customer/customer_register_step2/'.$id);        
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    //Submit the next Customer registration
    function customer_save_step2(Request $request){
        
        //Validate requests
        $request->validate([
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
        ]);

           $validID = time().'.'.$request->valid_id->extension();
           $request->valid_id->move(public_path('images'),$validID);
           //Insert to identification table
           $identifications = new Identification;
           $identifications->user_id = $request->user_id;
           $identifications->valid_id =  $validID;
           $identificationsave = $identifications->save();
          
        if($identificationsave){
            return redirect('customer/customer_register')->with('success', 'Successfully created an account. Please check your email to verify it.');
        }
        else {
            return redirect('customer/customer_register')->with('fail','Something went wrong, try again later ');
        }
    }

    //Update Customer's user table 
    //Email is now verified
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
        //Check if the email inputted exist in user table
        //A user is a customer which the email is already verified
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
            //Check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->user_id);
                return redirect('customer/customer_dashboard');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    //Customer update his/her information 
    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name'=>'required',
            'email'=>'required',
            'contact_number'=>'required|numeric|digits:11',

        ]);
        //Update user table
        $update= User::Where('user_id', $request->user_id )->update(['full_name' => $request->full_name, 'email' => $request->email,'contact_number' => $request->contact_number]);
        //Update address table
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
     //Customer delete an address
     function deleteAddress(Request $request){
            $deleteAddress= Address::Where('address_id', $request->address_id )->delete();
         
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
 
    //Cleaner report page
    function cleaner_reports(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_reports', $data);
    }
    
    //Customer profile page
    function customer_profile(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_profile', $data);
    }

    //Cleaner initial registration process
    function cleaner_register(){
        return view('cleaner.cleaner_register');
    }

    //Cleaner next registration process
    function cleaner_register_step2(Request $request){
        return view('cleaner.cleaner_register_step2')->with('user_id', $request->route('id'));
    }

    //Cleaner last registration process
    function cleaner_register_step3(Request $request){
        return view('cleaner.cleaner_register_step3')->with('cleaner_id', $request->route('id'));
    }

    //Submit initial Cleaner registration
    function cleaner_save(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email|unique:users',
            'contact_number'=>'required|numeric|digits:11',
            'password'=>'required|confirmed|min:5|max:12',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg', // Only allow .jpg, .gif, .svg and .png file types.
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
            \Mail::to($email)->send(new \App\Mail\SendMailCleaner($details));

            if($cleaner_save){
                return redirect('cleaner/cleaner_register_step2/'.$id);
            }
            else {
                return back()->with('fail','Something went wrong, try again later ');
            }
    }

    //Submit next Cleaner registration
    function cleaner_save_step2(Request $request){
        
        //Validate Requests
        $request->validate([
            'valid_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'age' => 'required|numeric',
            'address'=>'required',
        ]);
             //Save the file in the /public/ folder under a new folder named /images
             $validId = time().'.'.$request->valid_id->extension();
             $request->valid_id->move(public_path('images'),$validId);

             //Insert to identification table
             $identifications = new Identification;
             $identifications->user_id = $request->user_id;
             $identifications->valid_id = $validId;
             $identifications = $identifications->save();
            //Insert to cleaner table
             $cleaners = new Cleaner;
             $cleaners->user_id = $request->user_id;
             $cleaners->birthday = $request->birthday;
             $cleaners->address = $request->address;
             $cleaner_save = $cleaners->save();
             $id = $cleaners->cleaner_id;

            if($cleaner_save){
                return redirect('cleaner/cleaner_register_step3/'.$id);
            }
            else {
                return back()->with('fail','Something went wrong, try again later ');
            }
    }

    //Submit last Cleaner registration
    function cleaner_save_step3(Request $request){
        
        //Validate Requests
        $request->validate([
            'requirement' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

             //Save the file in the /public/ folder under a new folder named /images
             $require = time().'.'.$request->requirement->extension();
             $request->requirement->move(public_path('images'),$require);
             //Insert to clearance table
             $clearances = new Clearance;
             $clearances->cleaner_id = $request->cleaner_id;
             $clearances->requirement = $require;
             $clearances->description = 'NBI Clearance';
             $cleaner_save = $clearances->save();

            if($cleaner_save){
                return redirect('cleaner/cleaner_register')->with('success', 'Successfully created an account. Please check your email to verify it.');
            }
            else {
                return back()->with('fail','Something went wrong, try again later ');
            }
    }
    //Update Cleaner's user table that email address is now verified
    function verify_cleaner(Request $request){
        $verify_cleaner = User::Where('user_id', $request->route('id') )->update(['email_verified_at' => now()]);
        
        if($verify_cleaner){
            return redirect('cleaner/cleaner_welcome')->with('success', 'Email Verified');
        }
        else {
            return redirect('cleaner/cleaner_welcome')->with('fail','Something went wrong, try again later ');
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
        //Check if the email inputted exist in user table
        //A user is a cleaner with a verified email
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
            //Check password
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
    //Cleaner profile page
    function cleaner_profile(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_profile', $data);
    }
    //Cleaner update his/her information
    public function updateCleaner(Request $request)
    {
        $request->validate([
            'full_name'=>'required',
            'email'=>'required',
            'contact_number'=>'required|numeric|digits:11',
            'address'=>'required',
            'age'=>'required',
        ]);
        //Update user table
        $updateCleaner= User::Where('user_id', $request->user_id )->update(['full_name' => $request->full_name, 'email' => $request->email,'contact_number' => $request->contact_number]);
        //Update cleaner table
        $updateCleaner= Cleaner::Where('user_id', $request->user_id )->update(['address' => $request->address, 'age' => $request->age]);

        if($updateCleaner){   
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
    function contactUs(Request $request){
        
        $full_name = $request->full_name;
        $email = $request->email;
        $message = $request->message;

        $details = [
         'name' => $full_name,
         'email' => $email ,
         'message' => $message,
        ];
        \Mail::to('cleaningservicesweep@gmail.com')->send(new \App\Mail\ContactUs($details));

        return redirect('contact_us');
    }

    //Admin add a new employee
    function addEmployee(Request $request){
        
        //Validate Requests
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email|unique:employees',
            'contact_number'=>'required|numeric|digits:11',
            'department'=>'required',
            'position'=>'required'
        ]);
            $employees = new Employee;
            $employees->employee_code = $request->employee_code; 
            $employees->full_name = $request->full_name; 
            $employees->email = $request->email; 
            $employees->contact_number = $request->contact_number; 
            $employees->department = $request->department; 
            $employees->position = $request->position; 
            $employees = $employees->save();
            
            if($employees){
                return back()->with('success', 'Successfully created an account. Please check your email to verify it.');
            }
            else {
                return back()->with('fail','Something went wrong, try again later ');
            }
    }

    //View Employee timein/timeout page
    function employee_login(){
        return view('employee.login');
    }

    //Employee time in
    function timeIn(Request $request){
        $request->validate([
            'employee_code'=>'required'
        ]);

        if($request->timeIn != null){
            $time_entries = new Time_entry;
            $time_entries->employee_code = $request->employee_code;
            $time_entries->time_start = $request->timeIn;
            $time_entries = $time_entries->save();
            return back()->with('success-timein', 'Successful');
        }
        elseif($request->timeOut != null){
            $id = Time_entry::where('employee_code', $request->employee_code)->where('time_end', null)->value('id');
            if($id == null){
                return back()->with('fail-timeout', 'Time in first');
            }
            else{
                $timeOut_entries = Time_entry::where('id', $id)->update(['time_end' => $request->timeOut]);
                return back()->with('success-timeout', 'Successful');
            }
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    //Employee generate his/her payslip
    function payslip(Request $request)
    {
        $data = ['LoggedUserInfo' => Admin::where('admin_id', '=', session('LoggedUser'))->first()];
        return view('payslip', $data)->with('id', $request->route('id'));
    }

    //Generate top performing Cleaners report
    function cleaners_performance()
    {
        $data = ['LoggedUserInfo' => Admin::where('admin_id', '=', session('LoggedUser'))->first()];
        if (session()->has('LoggedUser')) {
            return view('cleaners_performance', $data);
        }
        return redirect('/');
    }

    //Generate top performing Employees report
    function employees_performance()
    {
        $data = ['LoggedUserInfo' => Admin::where('admin_id', '=', session('LoggedUser'))->first()];
        if (session()->has('LoggedUser')) {
            return view('employees_performance', $data);
        }
        return redirect('/');
    }

    //Generate the total commission or salary of the Cleaner
    function cleaner_salary()
    {
        $data = ['LoggedUserInfo' => Admin::where('admin_id', '=', session('LoggedUser'))->first()];
        if (session()->has('LoggedUser')) {
            return view('cleaner_salary', $data);
        }
        return redirect('/');
    }
}


            

            