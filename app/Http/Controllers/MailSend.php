<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use App\Models\User; 

class MailSend extends Controller
{
    public function mailsend(Request $request){
        $details = [
            'title' => 'Good day!',
            'body' => 'Your account is now Approved.',
        ];

        $email = User::Where('user_id', $request->route('id'))->value('email');
        \Mail::to($email)->send(new \App\Mail\SendMailApprove($details));
        $update = User::Where('user_id', $request->route('id'))->update(['account_status' => 'Approved']);
        $userType = User::Where('user_id', $request->route('id'))->value('user_type');
        if($userType == 'Customer'){
            return redirect()->route('admin_user_customer');
        }
        else {
            return redirect()->route('admin_user_cleaner');
        }
    }
}
