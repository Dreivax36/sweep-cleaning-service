<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      
        if(!session()->has('LoggedUser') && $request->path() !='/' ) {
            if ( $request->path() =='cleaner/cleaner_dashboard' || $request->path() =='cleaner/cleaner_history' ||  $request->path() =='cleaner/cleaner_profile' || $request->path() =='cleaner/cleaner_job'){
                return redirect('cleaner/cleaner_login')->with('fail', 'You must be logged in');
            }
            if ( $request->path() =='customer/customer_dashboard' || $request->path() =='customer/customer_history' || $request->path() =='customer/customer_profile' ||  $request->path() =='customer/customer_services' || $request->path() =='customer/customer_transaction' ){
                return redirect('customer/customer_login')->with('fail', 'You must be logged in');
            }
            if ($request->path() =='admin_dashboard' || $request->path() =='admin_payroll_cleaner' || $request->path() =='admin_payroll_employee' && $request->path() =='admin_payroll' && $request->path() =='admin_services' && $request->path() =='admin_transaction_history' && $request->path() =='admin_transaction' && $request->path() =='admin_user_cleaner' && $request->path() =='admin_user_customer' && $request->path() =='admin_user' ){
                return redirect('auth/login')->with('fail', 'You must be logged in');
            }
            
        }
        
        elseif(session()->has('LoggedUser')){ 
            if ($request->path() =='auth/login' || $request->path() =='auth/register'){
                return back();
            }
            elseif ($request->path() =='customer/customer_login' || $request->path() =='customer/customer_register' || $request->path() == '/sanitation' || $request->path() == '/cleaning'){
                return back();
            }
            elseif ($request->path() =='cleaner/cleaner_login' || $request->path() =='cleaner/cleaner_register'){
                return back();
            }
            elseif($request->path() =='/'){
                return back();
            }
        }
    
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
