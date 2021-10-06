<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use App\Models\User; 

class MailSend extends Controller
{
    public function mailsend(Request $request){
        $details = [
            'title' => 'Mail from Sweep Cleaning Service',
            'body' => 'Your account is now Verified.',
        ];

        $email = User::Where('user_id', $request->route('id'))->value('email');
        \Mail::to($email)->send(new SendMail($details));
        $update = User::Where('user_id', $request->route('id'))->update(['account_status' => 'Verified']);
        $userType = User::Where('user_id', $request->route('id'))->value('user_type');
        if($userType == 'Customer'){
            return redirect()->route('admin_user_customer');
        }
        else {
            return redirect()->route('admin_user_cleaner');
        }
    }
}
