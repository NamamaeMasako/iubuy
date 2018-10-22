<?php

namespace App\Http\Middleware;

use Session;
use Closure;

class SignPost
{
    public function handle($request, Closure $next)
    {
    	Session::forget('active-tab');
    	$tab = explode("/", $request->getpathInfo());
        Session::set('active-tab',$tab[1]);
        
        return $next($request);
    }
}
