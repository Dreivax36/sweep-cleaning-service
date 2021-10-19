<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use App\Models\User; 

class MailSend extends Controller
{
    
    public function mailsend(Request $request){
        //Notify the user that their account is validated
        $name = User::Where('user_id', $request->route('id'))->value('full_name');
        $details = [
            'title' => 'Good day!',
            'body' => 'Your account is now Validated.',
            'name' =>  $name,
        ];

        $email = User::Where('user_id', $request->route('id'))->value('email');
        \Mail::to($email)->send(new \App\Mail\SendMailApprove($details));

        //Update account status to validated
        $update = User::Where('user_id', $request->route('id'))->update(['account_status' => 'Validated']);
        $userType = User::Where('user_id', $request->route('id'))->value('user_type');

        if($userType == 'Customer'){
            return redirect()->route('admin_user_customer')->with('success', 'Account Validated Successful');
        }
        else {
            return redirect()->route('admin_user_cleaner')->with('success', 'Account Validated Successful');;
        }
    }
}
