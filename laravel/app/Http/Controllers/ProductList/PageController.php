<?php

namespace App\Http\Controllers\Productlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Products;
use App\Productlists;
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
        $tb_Products = Products::where('shops_id', $shop_id)->orderby('created_at')->get();
        $tb_Productlists = Productlists::where('shops_id', $shop_id)->where('selling',1)->orderby('created_at')->get();
        return view('productlist.edit',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop,
            'tb_Products' => $tb_Products,
            'tb_Productlists' => $tb_Productlists
        ]);
    }

}