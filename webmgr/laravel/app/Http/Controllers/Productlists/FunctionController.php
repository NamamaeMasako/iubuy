<?php

namespace App\Http\Controllers\Productlists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use App\Productlists;
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

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'products_id' => 'required',
                'selling' => 'required',
            ],
            [
                'products_id.required' => '商品 - 必填',
                'selling.required' => '上架狀態 - 必填',
            ]
        );
        if($validator->fails()){
            $this->msg2session('danger',$validator->errors()->all());

            return back()->withInput();
        }
        $tb_Products = Products::find($request->products_id);
        if(empty($tb_Products)){
            $this->msg2session('danger',["找不到商品編號為 ".$new_tb_Users->id." 的商品"]);
        }else{
            $Productlists_id = time();
            $new_tb_Productlists = new Productlists();
            $new_tb_Productlists->id = $Productlists_id;
            $new_tb_Productlists->products_id = $tb_Products->id;
            $new_tb_Productlists->shops_id = $tb_Products->Shops->id;
            $new_tb_Productlists->sale_price = $tb_Products->original_price;
            $new_tb_Productlists->selling = $request->selling;
            $new_tb_Productlists->save();
            $this->msg2session('success',["商品編號 ".$tb_Products->id." 已成功上架"]);
        }
        if(isset($request->quick)){

            return redirect('/products');
        }

        return redirect('/products');
    }

    public function update(Request $request,$productlists_id)
    {
        $upd_tb_Productlists = Productlists::find($productlists_id);
        $change_count = array();
        if(isset($request->selling) && $request->selling != $upd_tb_Productlists->selling){
            $upd_tb_Productlists->selling = $request->selling;
            $change_count['selling'] = $upd_tb_Productlists->selling;
        }
        if(count($change_count) == 0){
            $this->msg2session("warning",["商品編號 ".$upd_tb_Productlists->products_id." 並未更新上架狀態"]);

            return back();
        }else{
            $upd_tb_Productlists->save();
            $msg = array();
            foreach ($change_count as $key => $value) {
                $item = null;
                $str = null;
                switch ($key) {
                    case 'selling':
                        $item = "上架狀態";
                        $str = "變更";
                        break;
                }
                array_push($msg, "商品編號 ".$upd_tb_Productlists->products_id." 的".$item."已".$str);
            }
            $this->msg2session('success',$msg);
            if(isset($request->quick)){

                return redirect('/products');
            }
            
            return redirect('/products');
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