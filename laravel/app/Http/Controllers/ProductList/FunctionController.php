<?php

namespace App\Http\Controllers\Productlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Products;
use App\Productlists;
use App\Shops;
use Validator;

class FunctionController extends Controller
{

	private $shops_img_dir = 'webmgr/upload/shops/';

    public function __construct()
    {

    }

    public function create(Request $request,$member_id,$shop_id)
    {
        if(empty($request->product)){
            return back()->withErrors(["請至少選擇一項商品"])->withInput();
        }
        $validator = Validator::make($request->all(),
            [
                'sale_price' => 'required',
            ],
            [
                'sale_price.required' => '實際售價 - 必填',
            ]
        );
        if($validator->fails()){

            return back()->withErrors($validator)->withInput();
        }
        $upd_tb_Productlists = Productlists::where('sale_price',$request->sale_price)->first();
        if(!empty($upd_tb_Productlists)){
            $upd_tb_Productlists->selling = 1;
            $upd_tb_Productlists->save();
        }else{
            $Productlists_id = time();
            $new_tb_Productlists = new Productlists;
            $new_tb_Productlists->id = $Productlists_id;
            $new_tb_Productlists->products_id = $request->product;
            $new_tb_Productlists->shops_id = $shop_id;
            $new_tb_Productlists->sale_price = $request->sale_price;
            $new_tb_Productlists->selling = 1;
            $new_tb_Productlists->save();
        }

        return redirect('/member/'.$member_id.'/shop/'.$shop_id.'/productlist/edit');
    }

    public function update(Request $request,$member_id,$shop_id,$productlsit_id)
    {
        $upd_tb_Products = Products::find($request->product);
        $upd_tb_Products->onshelf = 0;
        $upd_tb_Products->save();
        $upd_tb_ProductLists = Product_lists::find($productlsit_id);
        $upd_tb_ProductLists->onshelf = 0;
        $upd_tb_ProductLists->save();

        return redirect('/member/'.$member_id.'/shop/'.$shop_id.'/productlist/edit');
    }

}