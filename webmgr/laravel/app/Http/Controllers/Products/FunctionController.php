<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use App\Shops;
use Cookie;
use Session;
use Validator;

class FunctionController extends Controller
{
	private $cookiesmins = 60;
    private $products_img_dir = 'upload/products/';

    private function msg2session($type,array $content)
    {
        $icon = null;
        $str = null;
        switch ($type) {
            case 'danger':
                $icon = 'ban';
                $str = "錯誤";
                break;
            case 'warning':
                $icon = 'warning';
                $str = "警告";
                break;
            case 'info':
                $icon = 'info';
                $str = "";
                break;
            case 'success':
                $icon = 'check';
                $str = "成功";
                break;
        }
        $title = "你有".count($content)."個".$str."訊息";
        Session::flash('msg',json_encode([
            "type" => $type,
            "icon" => $icon,
            "title" => $title,
            "content" => $content
        ], JSON_UNESCAPED_UNICODE));
    }

    private function randtext($length) {
        $password_len = $length;    //字串長度
        $password = '';
        $word = 'abcdefghijklmnopqrstuvwxyz0123456789';   //亂數內容
        $len = strlen($word);
        for ($i = 0; $i < $password_len; $i++) {
            $password .= $word[rand() % $len];
        }
        return $password;
    }

	//--------------------------------------------------------------------

    public function __construct()
    {

    }

    public function search(Request $request)
    {
        Cookie::queue(Cookie::forget('productsSearch'));
        $arr_search = array_filter($request->all(),function($v){
            if($v != null){

                return true;
            }else{

                return false;
            }
        });
        if(count($arr_search) != 0){
            if(!empty($arr_search['created_at'])){
                $arr_search['created_at'] = explode(" ~ ",$arr_search['created_at']);
                $arr_search['created_at'][0] .=' 00:00:00';
                $arr_search['created_at'][1] .=' 23:59:59';
            }
            Cookie::queue('productsSearch', $arr_search, $this->cookiesmins);
        }

    	return redirect('/products')->withInput();
    }

    public function clearsearch()
    {
        Cookie::queue(Cookie::forget('productsSearch'));

        return redirect('/products');
    }

    public function update(Request $request,$products_id)
    {
        $upd_tb_Products = Products::find($products_id);
        $change_count = array();
        $pic_arr = json_decode($upd_tb_Products->pic,true);
        if(!empty($request->name) && $request->name != $upd_tb_Products->name){
            $upd_tb_Products->name = $request->name;
            $change_count['name'] = $upd_tb_Products->name;
        }
        if(!empty($request->intro) && $upd_tb_Products->intro != $request->intro){
            $change_count['intro'] = $upd_tb_Products->intro;
            $upd_tb_Products->intro = $request->intro;
        }
        if($upd_tb_Products->checked != $request->checked){
            $upd_tb_Products->checked = $request->checked;
            $change_count['checked'] = $upd_tb_Products->checked;
        }
        if(count($request->pic)>0){
            $pic_arr = array_diff($pic_arr, $request->pic);
            $pic_arr = array_values($pic_arr);
            foreach ($request->pic as $pic) {
                if(in_array($pic, $pic_arr)){
                    \File::delete($this->products_img_dir.'shop_'.$upd_tb_Products->shops_id.'/'.$products_id.'/'.$pic);
                }
            }
            if(count($pic_arr)<=0){
                $imgName = time().'.jpg';
                \Image::make($this->products_img_dir.'default_product.jpg')->save($this->products_img_dir.'shop_'.$upd_tb_Products->shops_id.'/'.$products_id.'/'.$imgName);
                array_push($pic_arr, $imgName);
            }
            $change_count['pic'] = $pic_arr;
        }
        if(count($change_count) == 0){
            $this->msg2session("warning",["商品編號 ".$upd_tb_Products->id." 並未更新任何資訊"]);

            return back();
        }else{
            $upd_tb_Products->pic = json_encode($pic_arr);
            $upd_tb_Products->save();
            $msg = array();
            foreach ($change_count as $key => $value) {
                $item = null;
                $str = null;
                switch ($key) {
                    case 'name':
                        $item = "商品名稱";
                        $str = "變更";
                        break;
                    case 'intro':
                        $item = "商品介紹";
                        $str = "變更";
                        break;
                    case 'checked':
                        $item = "可否販賣";
                        $str = "變更";
                        break;
                    case 'info_name':
                        $item = "出貨資訊(店家名稱)";
                        $str = "變更";
                        break;
                    case 'pic':
                        $item = "商品照片";
                        $str = "重設";
                        break;
                }
                array_push($msg, "店家編號 ".$upd_tb_Products->id." 的".$item."已".$str);
            }
            $this->msg2session('success',$msg);
            if(isset($request->quick)){

                return redirect('/products');
            }
            
            return redirect('/products/edit/'.$upd_tb_Products->id);
        }
    }

    public function delete($product_id)
    {
        $upd_tb_Products = Products::find($product_id);
        \File::delete($this->shops_img_dir.$upd_tb_shops->avator);
        Products::destroy($product_id);
        $this->msg2session('success',["店家編號 ".$product_id." 已成功刪除"]);

        return redirect('/shops');
    }
}