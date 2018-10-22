<?php

namespace App\Http\Controllers\Shops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shops;
use Cookie;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $tb_Shops =Shops::orderby('created_at','desc');
        $arr_search = null;
        if(Cookie::get('shopsSearch')){
            $arr_search = Cookie::get('shopsSearch');
            if(isset($arr_search['created_at'])){
                $tb_Shops = $tb_Shops->whereBetween('created_at',$arr_search['created_at']);
            }
            if(isset($arr_search['name'])){
                $tb_Shops = $tb_Shops->where('name','like','%'.$arr_search['name'].'%');
            }
            if(isset($arr_search['email'])){
                $tb_Shops = $tb_Shops->where('email','like','%'.$arr_search['email'].'%');
            }
            if(isset($arr_search['admin'])){
                $tb_Shops = $tb_Shops->where('admin',$arr_search['admin']);
            }
            if(isset($arr_search['premission'])){
                $tb_Shops = $tb_Shops->where('premission',$arr_search['premission']);
            }  
        }
        $tb_Shops = $tb_Shops->paginate(10);

    	return view('shops.index',[
            "arr_search" => $arr_search,
            "tb_Shops" => $tb_Shops
        ]);
    }

    public function create()
    {
    	return view('shops.create');
    }

    public function edit($shop_id)
    {
        $tb_Shops = Shops::find($shop_id);

        return view('shops.edit',[
            'tb_Shops' => $tb_Shops
        ]);
    }

}