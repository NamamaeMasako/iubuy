<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use App\Shops;
use Cookie;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $tb_Products =Products::orderby('created_at','desc');
        $arr_search = null;
        if(Cookie::get('productsSearch')){
            $arr_search = Cookie::get('productsSearch');
            if(isset($arr_search['created_at'])){
                $tb_Products = $tb_Products->whereBetween('created_at',$arr_search['created_at']);
            }
            if(isset($arr_search['name'])){
                $tb_Products = $tb_Products->where('name','like','%'.$arr_search['name'].'%');
            }
            if(isset($arr_search['email'])){
                $tb_Products = $tb_Products->where('email','like','%'.$arr_search['email'].'%');
            }
            if(isset($arr_search['admin'])){
                $tb_Products = $tb_Products->where('admin',$arr_search['admin']);
            }
            if(isset($arr_search['premission'])){
                $tb_Products = $tb_Products->where('premission',$arr_search['premission']);
            }  
        }
        $tb_Products = $tb_Products->paginate(10);

    	return view('products.index',[
            "arr_search" => $arr_search,
            "tb_Products" => $tb_Products
        ]);
    }

    public function create()
    {
    	return view('Products.create');
    }

    public function edit($shop_id)
    {
        $tb_Products = Products::find($shop_id);

        return view('Products.edit',[
            'tb_Products' => $tb_Products
        ]);
    }

}