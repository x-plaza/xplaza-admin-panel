<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class authAndAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAuthenticated = session::get('authenticated');
        if(isset($isAuthenticated) && $isAuthenticated == 'true'){
            return $next($request);
        }
        else{
            Session::forget('authenticated');
            return redirect('/login');
            exit;
        }
       // return $next($request);
    }
}
