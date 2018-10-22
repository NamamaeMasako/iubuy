<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use App\Employees;

class ShopPremissionCheck
{
    public function handle($request, Closure $next)
    {
    	$tb_Employee = Employees::where('shops_id',$request->shop_id)->where('members_id',$request->member_id)->first();
    	if(empty($tb_Employee) || $tb_Employee->premission == 2){
    		
    		return back();
    	}
        
        return $next($request);
    }
}
