<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use Cookie;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $tb_Members = Members::orderby('admin')->orderby('created_at','desc');
        $arr_search = null;
        if(Cookie::get('membersSearch')){
            $arr_search = Cookie::get('membersSearch');
            if(isset($arr_search['created_at'])){
                $tb_Members = $tb_Members->whereBetween('created_at',$arr_search['created_at']);
            }
            if(isset($arr_search['name'])){
                $tb_Members = $tb_Members->where('name','like','%'.$arr_search['name'].'%');
            }
            if(isset($arr_search['email'])){
                $tb_Members = $tb_Members->where('email','like','%'.$arr_search['email'].'%');
            }
            if(isset($arr_search['admin'])){
                $tb_Members = $tb_Members->where('admin',$arr_search['admin']);
            }
            if(isset($arr_search['premission'])){
                $tb_Members = $tb_Members->where('premission',$arr_search['premission']);
            }  
        }
        $count_Members = array();
        for($i = 0;$i <= 1;$i++){
            $tb_Members_copy = clone $tb_Members;
            $count_Members[$i] = $tb_Members_copy->where('admin',$i)->get();
        }
        $tb_Members = $tb_Members->paginate(10);

    	return view('members.index',[
            "arr_search" => $arr_search,
            "tb_Members" => $tb_Members,
            "count_Members" => $count_Members,
        ]);
    }

    public function create()
    {
    	return view('members.create');
    }

    public function edit($user_id)
    {
        $tb_Members = Members::find($user_id);

        return view('members.edit',[
            'tb_Members' => $tb_Members
        ]);
    }

}