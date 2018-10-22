<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Product_lists;
use App\Shops;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function list($member_id)
    {
        $tb_Member = Members::find($member_id);
        $tb_Shop = Shops::where('members_id', $member_id)->get();
        return view('shop.list',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop
        ]);
    }

    public function create($member_id)
    {
        $tb_Member = Members::find($member_id);
        return view('shop.create',[
            'tb_Member' => $tb_Member
        ]);
    }

    public function edit($member_id,$shop_id)
    {
        $tb_Member = Members::find($member_id);
        $tb_Shop = Shops::find($shop_id);
        $tb_ProductLists = Product_lists::where('shops_id',$shop_id)->where('onshelf',1)->get();
        return view('shop.edit',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop,
            'tb_ProductLists' => $tb_ProductLists
        ]);
    }

}