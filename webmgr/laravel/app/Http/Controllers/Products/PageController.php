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
            if(isset($arr_search['selling'])){
                $tb_Productlists = Productlists::where('selling',1);
                if($arr_search['selling'] == 1){
                    $tb_Products = $tb_Products->whereIn('id',$tb_Productlists->pluck('products_id'));
                }else{
                    $tb_Products = $tb_Products->whereNotIn('id',$tb_Productlists->pluck('products_id'));
                }
            }
            if(isset($arr_search['price'])){
                $tb_Products = $tb_Products->whereBetween('original_price',$arr_search['price']);
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

    public function edit($product_id)
    {
        $tb_Products = Products::find($product_id);
        $tb_Productlists = Productlists::where('products_id',$product_id)->where('selling',1)->get();

        return view('Products.edit',[
            'tb_Products' => $tb_Products,
            'tb_Productlists' => $tb_Productlists
        ]);
    }

}