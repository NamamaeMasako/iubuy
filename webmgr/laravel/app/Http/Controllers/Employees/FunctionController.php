<?php

namespace App\Http\Controllers\shops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shops;
use Cookie;
use Session;
use Validator;

class FunctionController extends Controller
{
	private $cookiesmins = 60;
    private $shops_img_dir = 'upload/shops/';

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
        Cookie::queue(Cookie::forget('shopsSearch'));
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
            Cookie::queue('shopsSearch', $arr_search, $this->cookiesmins);
        }

    	return redirect('/shops')->withInput();
    }

    public function clearsearch()
    {
        Cookie::queue(Cookie::forget('shopsSearch'));

        return redirect('/shops');
    }

    public function update(Request $request,$shop_id)
    {
        $upd_tb_Shops = Shops::find($shop_id);
        $change_count = array();
        $info_arr = json_decode($upd_tb_Shops->info);
        if(!empty($request->name)){
            $change_count['name'] = $upd_tb_Shops->name;
            $upd_tb_Shops->name = 'Shop_'.$upd_tb_shops->id;
        }
        if(isset($request->premission) && $upd_tb_Shops->premission != $request->premission){
            $change_count['premission'] = $upd_tb_Shops->premission;
            $upd_tb_Shops->premission = $request->premission;
        }
        if(!empty($request->logo)){
            $imgName = $upd_tb_Shops->id.'.jpg';
            \File::delete($this->shops_img_dir . $upd_tb_Shops->logo);
            \File::makeDirectory($this->shops_img_dir,0775,true,true);
            \Image::make($this->shops_img_dir.'default_shop.jpg')->save($this->shops_img_dir.$imgName);
            $upd_tb_Shops->logo = $imgName;
            $change_count['logo'] = $request->logo;
        }
        if(!empty($request->info_name) && $request->info_name != $info_arr->name){
            $info_arr->name = $request->info_name;
            $change_count['info_name'] = $info_arr->name;
        }
        if(!empty($request->taxid) && $request->taxid != $info_arr->taxid){
            $info_arr->taxid = $request->taxid;
            $change_count['taxid'] = $info_arr->taxid;
        }
        if(!empty($request->info_email) && $request->info_email != $info_arr->email){
            $info_arr->name = $request->info_email;
            $change_count['info_email'] = $info_arr->email;
        }
        if(!empty($request->phone) && $request->phone != $info_arr->phone){
            $info_arr->phone = $request->phone;
            $change_count['phone'] = $info_arr->phone;
        }
        if(!empty($request->address) && $request->address != $info_arr->address){
            $info_arr->address = $request->address;
            $change_count['address'] = $info_arr->address;
        }
        if(count($change_count) == 0){
            $this->msg2session("warning",["店家編號 ".$upd_tb_Shops->id." 並未更新任何資訊"]);

            return back();
        }else{
            if($info_arr != json_decode($upd_tb_Shops->info)){
                $upd_tb_Shops->info = json_encode($info_arr);
            }
            $upd_tb_Shops->save();
            $msg = array();
            foreach ($change_count as $key => $value) {
                $item = null;
                $str = null;
                switch ($key) {
                    case 'name':
                        $item = "店名";
                        $str = "重設";
                        break;
                    case 'premission':
                        $item = "權限";
                        $str = "變更";
                        break;
                    case 'avator':
                        $item = "頭像";
                        $str = "重設";
                        break;
                    case 'info_name':
                        $item = "出貨資訊(店家名稱)";
                        $str = "變更";
                        break;
                    case 'taxid':
                        $item = "出貨資訊(統一編號)";
                        $str = "變更";
                        break;
                    case 'info_email':
                        $item = "出貨資訊(電子郵件)";
                        $str = "變更";
                        break;
                    case 'phone':
                        $item = "出貨資訊(聯絡電話)";
                        $str = "變更";
                        break;
                    case 'address':
                        $item = "送貨資訊(收貨地址)";
                        $str = "變更";
                        break;
                }
                array_push($msg, "店家編號 ".$upd_tb_Shops->id." 的".$item."已".$str);
            }
            $this->msg2session('success',$msg);
            if(isset($request->quick)){

                return redirect('/shops');
            }
            
            return redirect('/shops/edit/'.$upd_tb_Shops->id);
        }
    }

    public function delete($shop_id)
    {
        $upd_tb_Shops = Shops::find($shop_id);
        \File::delete($this->shops_img_dir.$upd_tb_shops->avator);
        Shops::destroy($shop_id);
        $this->msg2session('success',["店家編號 ".$shop_id." 已成功刪除"]);

        return redirect('/shops');
    }
}