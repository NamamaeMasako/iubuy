<?php

namespace App\Http\Controllers\ProductList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Products;
use App\Product_lists;
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
                'sale_price.required' => '售價 - 必填',
            ]
        );
        if($validator->fails()){

            return back()->withErrors($validator)->withInput();
        }
        if(in_array("", $request->sale_price)){
            return back()->withErrors(['售價 - 必填'])->withInput();
        }
        foreach ($request->product as $idx => $product) {
            $upd_tb_Products = Products::find($product);
            $upd_tb_Products->onshelf = 1;
            $upd_tb_Products->save();
            $ProductLists_id = time();
            $new_tb_ProductLists = new Product_lists;
            $new_tb_ProductLists->id = $ProductLists_id;
            $new_tb_ProductLists->products_id = $product;
            $new_tb_ProductLists->shops_id = $shop_id;
            $new_tb_ProductLists->sale_price = $request->sale_price[$idx];
            $new_tb_ProductLists->onshelf = 1;
            $new_tb_ProductLists->save();
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