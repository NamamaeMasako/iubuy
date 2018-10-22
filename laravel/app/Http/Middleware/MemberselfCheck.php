<?php

namespace App\Http\Middleware;

use Session;
use Closure;

class MemberselfCheck
{
    public function handle($request, Closure $next)
    {
    	if(\Auth::user()->id != $request->member_id){

            return back();
    	}
        
        return $next($request);
    }
}
