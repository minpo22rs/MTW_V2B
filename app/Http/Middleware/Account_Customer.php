<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;
use Session;

class Account_Customer
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
        if (@Auth::guard('ecom_customer')->user()->id) {
            return $next($request);
        } else {
            Session::put('frontUrl', $request->getPathInfo());
            //dd($request);
            //dd(Session::all());exit;
            return redirect('login'); 
        }
    }
}
