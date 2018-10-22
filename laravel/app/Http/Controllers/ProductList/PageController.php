<?php

namespace App\Http\Controllers\ProductList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Products;
use App\Product_lists;
use App\Shops;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function edit($member_id,$shop_id)
    {
        $tb_Member = Members::find($member_id);
        $tb_Shop = Shops::find($shop_id);
        $tb_Product = Products::where('shops_id', $shop_id)->where('onshelf',0)->orderby('created_at')->get();
        $tb_ProductList = Product_lists::where('shops_id', $shop_id)->where('onshelf',1)->orderby('created_at')->get();
        return view('productlist.edit',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop,
            'tb_Product' => $tb_Product,
            'tb_ProductList' => $tb_ProductList
        ]);
    }

}