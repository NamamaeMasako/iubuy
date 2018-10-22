<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Products;
use App\Shops;
use Validator;

class FunctionController extends Controller
{

	private $products_img_dir = 'webmgr/upload/products/';

    public function __construct()
    {

    }

    public function create(Request $request,$member_id,$shop_id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255|unique:products,name',
                'intro' => 'required|max:255',
                'original_price' => 'required|numeric',
            ],
            [
                'name.required' => '商品名稱 - 必填',
                'name.max' => '商品名稱 - 字數過多',
                'name.unique' => '商品名稱 - 商品名稱已存在',
                'intro.required' => '商品介紹 - 必填',
                'intro.max' => '商品介紹 - 字數過多',
                'original_price.required' => '商品定價 - 必填',
                'original_price.numeric' => '商品定價 - 須為數字',
            ]
        );
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $product_id = time();
        $new_tb_Product = new Products;
        $new_tb_Product->id = $product_id;
        $new_tb_Product->shops_id = $shop_id;
        $new_tb_Product->name = $request->name;
        $new_tb_Product->intro = $request->intro;
        $new_tb_Product->original_price = $request->original_price;
        $new_tb_Product->checked = 0;
        $new_tb_Product->onshelf = 0;
        $files = $request->file('pic');
        $directory = $this->products_img_dir.'shop_'.$shop_id.'/'.$product_id;
        $pic_arr = array();
        if ($files) {
            foreach ($files as $idx => $file) {
                $extension = $file->getClientOriginalExtension();
                $imgName = time().'.'.$extension;
                \File::makeDirectory($directory,0775,true,true);
                \Image::make($file->getRealPath())->save($directory.'/'.$imgName);
                array_push($pic_arr, $imgName);
            }
        }
        $new_tb_Product->pic = json_encode($pic_arr);
        $new_tb_Product->save();

        return redirect('/member/'.$member_id.'/shop/'.$shop_id.'/productlist/edit');
    }

    public function update(Request $request,$member_id,$shop_id,$product_id)
    {
        $upd_tb_Products = Products::find($product_id);
        $change_count = array();
        $pic_arr = json_decode($upd_tb_Products->pic);
        if(!empty($request->name) && $request->name != $upd_tb_Products->name){
            $change_count['pic'] = $upd_tb_Products->name;
            $upd_tb_Products->name = $request->name;
        }
        if(!empty($request->intro) && $request->intro != $upd_tb_Products->intro){
            $change_count['intro'] = $upd_tb_Products->intro;
            $upd_tb_Products->intro = $request->intro;
        }
        if(!empty($request->original_price) && $request->original_price != $upd_tb_Products->original_price){
            $change_count['original_price'] = $upd_tb_Products->original_price;
            $upd_tb_Products->original_price = $request->original_price;
        }
        if(!empty($request->pic_name)){
            $file = $request->file('pic');
            if($file){
                $extension = $file->getClientOriginalExtension();
                $imgName = time().'.'.$extension;
                if(!empty($pic_arr[$request->pic_name-1])){
                    \File::delete($this->products_img_dir.'/shop_'.$shop_id.'/'.$product_id.'/'.$pic_arr[$request->pic_name-1]);
                }
                \Image::make($file->getRealPath())->save($this->products_img_dir.'/shop_'.$shop_id.'/'.$product_id.'/'.$imgName);
                $pic_arr[$request->pic_name-1] = $imgName;
                $change_count['pic'] = json_decode($upd_tb_Products->pic);
            }
            if(!empty($request->way)){
                $standby = $pic_arr[$request->pic_name-1];
                if($request->way == 'front'){
                    $pic_arr[$request->pic_name-1] = $pic_arr[$request->pic_name-2];
                    $pic_arr[$request->pic_name-2] = $standby;
                    $change_count['pic'] = json_decode($upd_tb_Products->pic);
                }elseif($request->way == 'back'){
                    $pic_arr[$request->pic_name-1] = $pic_arr[$request->pic_name];
                    $pic_arr[$request->pic_name] = $standby;
                    $change_count['pic'] = json_decode($upd_tb_Products->pic);
                }
            }
        }
        if($pic_arr != json_decode($upd_tb_Products->pic)){
            $upd_tb_Products->pic = json_encode($pic_arr);
        }
        if(count($change_count) > 0){
            $upd_tb_Products->save();
        }
            
        return redirect('/member/'.$member_id.'/shop/'.$upd_tb_Products->shops_id.'/product/'.$upd_tb_Products->id.'/edit');
    }

    public function delete(Request $request,$member_id,$shop_id,$product_id)
    {
        $upd_tb_Products = Products::find($product_id);
        $change_count = array();
        $pic_arr = json_decode($upd_tb_Products->pic);
        $file = \File::get($this->products_img_dir.'/shop_'.$shop_id.'/'.$product_id.'/'.$pic_arr[$request->pic_name-1]);
        if($file){
            \File::delete($this->products_img_dir.'/shop_'.$shop_id.'/'.$product_id.'/'.$pic_arr[$request->pic_name-1]);
            unset($pic_arr[$request->pic_name-1]);
            $pic_arr = array_values($pic_arr);
            $change_count['pic'] = json_decode($upd_tb_Products->pic);
        }
        if($pic_arr != json_decode($upd_tb_Products->pic)){
            $upd_tb_Products->pic = json_encode($pic_arr);
        }
        if(count($change_count) > 0){
            $upd_tb_Products->save();
        }
            
        return redirect('/member/'.$member_id.'/shop/'.$upd_tb_Products->shops_id.'/product/'.$upd_tb_Products->id.'/edit');
    }
}