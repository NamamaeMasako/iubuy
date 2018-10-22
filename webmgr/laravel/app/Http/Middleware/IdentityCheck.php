<?php

namespace App\Http\Middleware;

use Session;
use Closure;

class IdentityCheck
{
	private function msg2session($type,array $content)
    {
        $icon = null;
        $str = null;
        switch ($type) {
            case 'danger':
                $icon = 'ban';
                $str = "錯誤";
                break;
            case 'warning':
                $icon = 'warning';
                $str = "警告";
                break;
            case 'info':
                $icon = 'info';
                $str = "";
                break;
            case 'success':
                $icon = 'check';
                $str = "成功";
                break;
        }
        $title = "你有".count($content)."個".$str."訊息";
        Session::flash('msg',json_encode([
            "type" => $type,
            "icon" => $icon,
            "title" => $title,
            "content" => $content
        ], JSON_UNESCAPED_UNICODE));
    }

    public function handle($request, Closure $next)
    {
    	if(\Auth::user()->admin != 0){
    		if(in_array($request->_method, ['post','delete']) || \Auth::user()->id != $request->id ){
	    		$this->msg2session('danger',['權限不足']);

	    		return back();
	    	}
    	}
        
        return $next($request);
    }
}
