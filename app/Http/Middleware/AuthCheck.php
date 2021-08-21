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
      
        if($request->path() =='sweep_welcome' || $request->path() =='auth/login' || $request->path() =='auth/register'){
            if(!session()->has('LoggedUser')  && ($request->path() !='auth/login' && $request->path() !='auth/register')){
                return redirect('auth/login')->with('fail', 'You must be logged in');
            }
            if(session()->has('LoggedUser')  && ($request->path() =='auth/login' || $request->path() =='auth/register')){
                return back();
            }
        }

        elseif($request->path() =='sweep_welcome' || $request->path() =='customer/customer_login' || $request->path() =='customer/customer_register'){
            if(!session()->has('LoggedUser')  && ($request->path() !='customer/customer_login' && $request->path() !='customer/customer_register')){
                return redirect('/customer/customer_login')->with('fail', 'You must be logged in');
            }
            elseif(session()->has('LoggedUser')  && ($request->path() =='customer/customer_login' || $request->path() =='customer/customer_register')){
                return back();
            }
        }

        elseif($request->path() =='sweep_welcome' || $request->path() =='cleaner/cleaner_login' || $request->path() =='cleaner/cleaner_register'){
            if(!session()->has('LoggedUser')  && ($request->path() !='cleaner/cleaner_login' && $request->path() !='cleaner/cleaner_register')){
                return redirect('/cleaner/cleaner_login')->with('fail', 'You must be logged in');
            }
            elseif(session()->has('LoggedUser')  && ($request->path() =='cleaner/cleaner_login' || $request->path() =='cleaner/cleaner_register')){
                return back();
            }
        }
    
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
