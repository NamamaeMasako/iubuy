<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Cookie;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $tb_Users = Users::orderby('admin')->orderby('created_at','desc');
        $arr_search = null;
        if(Cookie::get('usersSearch')){
            $arr_search = Cookie::get('usersSearch');
            if(isset($arr_search['created_at'])){
                $tb_Users = $tb_Users->whereBetween('created_at',$arr_search['created_at']);
            }
            if(isset($arr_search['name'])){
                $tb_Users = $tb_Users->where('name','like','%'.$arr_search['name'].'%');
            }
            if(isset($arr_search['admin'])){
                $tb_Users = $tb_Users->where('admin',$arr_search['admin']);
            }
            if(isset($arr_search['email'])){
                $tb_Users = $tb_Users->where('email','like','%'.$arr_search['email'].'%');
            }   
        }
        $count_Users = array();
        for($i = 0;$i <= 1;$i++){
            $tb_Users_copy = clone $tb_Users;
            $count_Users[$i] = $tb_Users_copy->where('admin',$i)->get();
        }
        $tb_Users = $tb_Users->paginate(10);

    	return view('users.index',[
            "arr_search" => $arr_search,
            "tb_Users" => $tb_Users,
            "count_Users" => $count_Users,
        ]);
    }

    public function create()
    {
    	return view('users.create');
    }

    public function edit($user_id)
    {
        $tb_Users = Users::find($user_id);

        return view('users.edit',[
            'tb_Users' => $tb_Users
        ]);
    }

}