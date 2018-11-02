<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use App\Productlists;
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
            if(isset($arr_search['checked'])){
                $tb_Products = $tb_Products->where('checked',$arr_search['checked']);
            }
            if(isset($arr_search['onshelf'])){
                $tb_Products = $tb_Products->where('onshelf',$arr_search['onshelf']);
            }
            if(isset($arr_search['price'])){
                $tb_Products = $tb_Products->whereBetween('original_price',$arr_search['price']);
            }
        }
        $tb_Productlists = Productlists::where('selling',1);
        $tb_Products = $tb_Products->paginate(10);

    	return view('products.index',[
            "arr_search" => $arr_search,
            "tb_Productlists" => $tb_Productlists,
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