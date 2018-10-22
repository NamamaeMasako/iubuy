<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use Cookie;
use Session;
use Validator;

class FunctionController extends Controller
{
	private $cookiesmins = 60;
    private $members_img_dir = 'upload/members/';

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
        Cookie::queue(Cookie::forget('membersSearch'));
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
            Cookie::queue('membersSearch', $arr_search, $this->cookiesmins);
        }

    	return redirect('/members')->withInput();
    }

    public function clearsearch()
    {
        Cookie::queue(Cookie::forget('membersSearch'));

        return redirect('/members');
    }

    public function update(Request $request,$member_id)
    {
        $upd_tb_Members = Members::find($member_id);
        $change_count = array();
        $info_arr = json_decode($upd_tb_Members->info);
        if(!empty($request->name)){
            $change_count['name'] = $upd_tb_Members->name;
            $upd_tb_Members->name = 'Member_'.$upd_tb_Members->id;
        }
        if(!empty($request->password)){
            $change_count['password'] = $upd_tb_Members->password;
            $new_password = $this->randtext(6);
            $upd_tb_Members->password = bcrypt($new_password);
        }
        if(isset($request->admin) && $upd_tb_Members->admin != $request->admin){
            $change_count['admin'] = $upd_tb_Members->admin;
            $upd_tb_Members->admin = $request->admin;
        }
        if(isset($request->premission) && $upd_tb_Members->premission != $request->premission){
            $change_count['premission'] = $upd_tb_Members->premission;
            $upd_tb_Members->premission = $request->premission;
        }
        if(!empty($request->avator)){
            $imgName = $upd_tb_Members->id.'.jpg';
            \File::delete($this->members_img_dir . $upd_tb_Members->avator);
            \File::makeDirectory($this->members_img_dir,0775,true,true);
            \Image::make($this->members_img_dir.'default_member.jpg')->save($this->members_img_dir.$imgName);
            $upd_tb_Members->avator = $imgName;
            $change_count['avator'] = $request->avator;
        }
        if(!empty($request->info_name) && $request->info_name != $info_arr->name){
            $info_arr->name = $request->name;
            $change_count['info_name'] = $info_arr->name;
        }
        if(!empty($request->gender) && $request->gender != $info_arr->gender){
            $info_arr->gender = $request->gender;
            $change_count['gender'] = $info_arr->gender;
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
            $this->msg2session("warning",["會員編號 ".$upd_tb_Members->id." 並未更新任何資訊"]);

            return back();
        }else{
            if($info_arr != json_decode($upd_tb_Members->info)){
                $upd_tb_Members->info = json_encode($info_arr);
            }
            $upd_tb_Members->save();
            $msg = array();
            foreach ($change_count as $key => $value) {
                $item = null;
                $str = null;
                switch ($key) {
                    case 'password':
                        $item = "密碼";
                        if(\Auth::user()->admin == 0){
                            $str = "重設為".$new_password;
                        }else{
                            $str = "重設";
                        }
                        break;
                    case 'name':
                         $item = "暱稱";
                         $str = "重設";
                        break;
                    case 'admin':
                        $item = "階級";
                        $str = "變更";
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
                        $item = "收貨資訊(收件人)";
                        $str = "變更";
                        break;
                    case 'gender':
                        $item = "收貨資訊(性別)";
                        $str = "變更";
                        break;
                    case 'info_email':
                        $item = "收貨資訊(電子郵件)";
                        $str = "變更";
                        break;
                    case 'phone':
                        $item = "收貨資訊(聯絡電話)";
                        $str = "變更";
                        break;
                    case 'address':
                        $item = "收貨資訊(收貨地址)";
                        $str = "變更";
                        break;
                }
                array_push($msg, "會員編號 ".$upd_tb_Members->id." 的".$item."已".$str);
            }
            $this->msg2session('success',$msg);
            if(isset($request->quick)){

                return redirect('/members');
            }
            
            return redirect('/members/edit/'.$upd_tb_Members->id);
        }
    }

    public function delete($member_id)
    {
        $upd_tb_Members = Members::find($member_id);
        \File::delete($this->members_img_dir.$upd_tb_Members->avator);
        Members::destroy($member_id);
        $this->msg2session('success',["會員編號 ".$member_id." 已成功刪除"]);

        return redirect('/members');
    }
}