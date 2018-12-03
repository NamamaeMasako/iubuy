<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\MemberProfiles;
use App\Shops;
use App\Products;
use App\Employees;
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

    public function update(Request $request,$account)
    {
        $upd_tb_Members = Members::where('account',$account)->first();
        $upd_tb_MemberProfiles = MemberProfiles::where('members_account',$account)->first();
        $change_count = array();
        if(!empty($request->name)){
            $change_count['name'] = $upd_tb_Members->name;
            $upd_tb_Members->name = $account;
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
            \File::delete($this->members_img_dir . $upd_tb_Members->avator);
            $upd_tb_Members->avator = null;
            $change_count['avator'] = $request->avator;
        }
        if(!empty($request->real_first_name) && $request->real_first_name != $upd_tb_MemberProfiles->real_first_name){
            $upd_tb_MemberProfiles->real_first_name = $request->real_first_name;
            $change_count['real_name'] = $upd_tb_MemberProfiles->real_last_name.' '.$upd_tb_MemberProfiles->real_first_name;
        }
        if(!empty($request->real_last_name) && $request->real_last_name != $upd_tb_MemberProfiles->real_last_name){
            $upd_tb_MemberProfiles->real_last_name = $request->real_last_name;
            $change_count['real_name'] = $upd_tb_MemberProfiles->real_last_name.' '.$upd_tb_MemberProfiles->real_first_name;
        }
        if(!empty($request->gender) && $request->gender != $upd_tb_MemberProfiles->gender){
            $upd_tb_MemberProfiles->gender = $request->gender;
            $change_count['gender'] = $upd_tb_MemberProfiles->gender;
        }
        if(!empty($request->spare_email)){
            if(json_encode($request->spare_email) !=  $upd_tb_MemberProfiles->spare_email){
                $upd_tb_MemberProfiles->spare_email = json_encode($request->spare_email);
                $change_count['spare_email'] = $upd_tb_MemberProfiles->spare_email;
            }
        }
        if(!empty($request->spare_phone)){
            if(json_encode($request->spare_phone) !=  $upd_tb_MemberProfiles->spare_phone){
                $upd_tb_MemberProfiles->spare_phone = json_encode($request->spare_phone);
                $change_count['spare_phone'] = $upd_tb_MemberProfiles->spare_phone;
            }
        }
        if(!empty($request->address)){
            if(json_encode($request->address) !=  $upd_tb_MemberProfiles->address){
                $upd_tb_MemberProfiles->address = json_encode($request->address);
                $change_count['address'] = $upd_tb_MemberProfiles->address;
            }
        }
        if(count($change_count) == 0){
            $this->msg2session("warning",["會員 ".$upd_tb_Members->account." 並未更新任何資訊"]);
            if(isset($request->tab)){
                Session::flash('tab',$request->tab);
            }

            return back();
        }else{
            $upd_tb_Members->save();
            $upd_tb_MemberProfiles->save();
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
                    case 'real_name':
                        $item = "個人資訊(真實姓名)";
                        $str = "變更";
                        break;
                    case 'gender':
                        $item = "個人資訊(性別)";
                        $str = "變更";
                        break;
                    case 'info_email':
                        $item = "個人資訊(備援電子郵件)";
                        $str = "變更";
                        break;
                    case 'phone':
                        $item = "個人資訊(備援電話)";
                        $str = "變更";
                        break;
                    case 'address':
                        $item = "個人資訊(地址)";
                        $str = "變更";
                        break;
                }
                array_push($msg, "會員 ".$upd_tb_Members->account." 的".$item."已".$str);
            }
            $this->msg2session('success',$msg);
            if(isset($request->quick)){
                return redirect('/members');
            }elseif(isset($request->tab)){
                Session::flash('tab',$request->tab);
            }
            return redirect('/members/edit/'.$upd_tb_Members->account);
        }
    }

    public function delete($member_id)
    {
        $upd_tb_Members = Members::find($member_id);
        $upd_tb_Shops = Shops::where('members_id',$member_id);
        \File::delete($this->members_img_dir.$upd_tb_Members->avator);
        Members::destroy($member_id);
        $this->msg2session('success',["會員編號 ".$member_id." 已成功刪除"]);

        return redirect('/members');
    }
}