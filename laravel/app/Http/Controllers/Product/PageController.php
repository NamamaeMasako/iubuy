<?php

namespace App\Http\Controllers\Product;

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

    public function create($member_id,$shop_id)
    {
        $tb_Shop = Shops::find($shop_id);
        return view('product.create',[
            'tb_Shop' => $tb_Shop
        ]);
    }

    public function edit($member_id,$shop_id,$product_id)
    {
        $tb_Product = Products::find($product_id);
        return view('product.edit',[
            'tb_Product' => $tb_Product,
        ]);
    }

}