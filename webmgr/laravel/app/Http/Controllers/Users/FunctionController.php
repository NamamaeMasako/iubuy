<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Cookie;
use Session;
use Validator;

class FunctionController extends Controller
{
	private $cookiesmins = 60;
    private $users_img_dir = 'upload/users/';

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

	//--------------------------------------------------------------------

    public function __construct()
    {

    }

    public function search(Request $request)
    {
        Cookie::queue(Cookie::forget('usersSearch'));
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
            Cookie::queue('usersSearch', $arr_search, $this->cookiesmins);
        }

    	return redirect('/users')->withInput();
    }

    public function clearsearch()
    {
        Cookie::queue(Cookie::forget('usersSearch'));

        return redirect('/users');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'name.required' => '使用者名稱 - 必填',
                'name.max' => '使用者名稱 - 字數過多',
                'email.required' => '帳號(Email) - 必填',
                'email.email' => '帳號(Email) - 格式錯誤',
                'email.max' => '帳號(Email) - 字數過多',
                'email.unique' => '帳號(Email) - 此帳號已存在',
                'password.required' => '密碼 - 必填',
                'password.min' => '密碼 - 至少六位英數字',
                'password.confirmed' => '再次確認密碼 - 確認失敗',
            ]
        );
        if($validator->fails()){
            $this->msg2session('danger',$validator->errors()->all());

            return back()->withInput();
        }
        $new_tb_Users = new Users();
        $new_tb_Users->name = $request->name;
        $new_tb_Users->email = $request->email;
        $new_tb_Users->password = bcrypt($request->password);
        $new_tb_Users->admin = $request->admin;
        $new_tb_Users->save();
        $imgName = $new_tb_Users->id.'.jpg';
        \File::makeDirectory($this->users_img_dir,0775,true,true);
        \Image::make($this->users_img_dir.'default_user.jpg')->save($this->users_img_dir.$imgName);
        $new_tb_Users->avator = $imgName;
        $new_tb_Users->save();
        $this->msg2session('success',["管理員編號 ".$new_tb_Users->id." 已成功新增"]);

        return redirect('/users');
    }

    public function update(Request $request,$user_id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'old_password' => 'required_with:password,password_confirmation',
                'password' => 'required_with:old_password|confirmed',
            ],
            [
                'name.required' => '使用者名稱 - 必填',
                'name.max' => '使用者名稱 - 字數過多',
                'old_password.required_with' => '修改密碼 - 請填入舊密碼',
                'password.required_with' => '修改密碼 - 請填入新密碼',
                'password.confirmed' => '再次確認密碼 - 確認失敗',
            ]
        );
        if($validator->fails()){
            $this->msg2session('danger',$validator->errors()->all());

            return back()->withInput();
        }
        $upd_tb_Users = Users::find($user_id);
        $change_count = array();
        if(!empty($request->old_password)){
            if(\Hash::check($request->old_password, $upd_tb_Users->password)) {
                $change_count['password'] = $upd_tb_Users->password;
                $upd_tb_Users->password = bcrypt($request->new_password);
            }else{
                $this->msg2session("danger",["修改密碼 - 舊密碼輸入錯誤"]);

                return back()->withInput();
            }
        }
        if($upd_tb_Users->name != $request->name){
            $change_count['name'] = $upd_tb_Users->name;
            $upd_tb_Users->name = $request->name;
        }
        if(!empty($request->admin) && $upd_tb_Users->admin != $request->admin){
            $change_count['admin'] = $upd_tb_Users->admin;
            $upd_tb_Users->admin = $request->admin;
        }
        $file = $request->file('avator');
        if($file){
            $extension = $file->getClientOriginalExtension();
            $imgName = $upd_tb_Users->id.'.'.$extension;
            \File::delete($this->users_img_dir . $upd_tb_Users->avator);
            \File::makeDirectory($this->users_img_dir,0775,true,true);
            \Image::make($file->getRealPath())->save($this->users_img_dir.$imgName);
            $upd_tb_Users->avator = $imgName;
            $change_count['avator'] = $request->avator;
        }
        if(count($change_count) == 0){
            $this->msg2session("warning",["管理員編號 ".$upd_tb_Users->id." 並未更新任何資訊"]);

            return back();
        }else{
            $upd_tb_Users->save();
            $msg = array();
            foreach ($change_count as $key => $value) {
                $str = null;
                switch ($key) {
                    case 'password':
                        $str = "密碼";
                        break;
                    case 'name':
                         $str = "管理員名稱";
                        break;
                    case 'admin':
                        $str = "權限等級";
                        break;
                    case 'avator':
                        $str = "管理員頭像";
                        break;
                }
                array_push($msg, "管理員編號 ".$upd_tb_Users->id." 的".$str."已更新");
            }
            $this->msg2session('success',$msg);

            return redirect('/users');
        }
    }

    public function delete($user_id)
    {
        $tb_Users = Users::where('admin',0)->get();
        if(count($tb_Users) <=1 ){
            $this->msg2session('danger',["請至少保留一位最高權級管理員"]);

            return redirect('/users');
        }
        $upd_tb_Users = Users::find($user_id);
        \File::delete($this->users_img_dir.$upd_tb_Users->avator);
        Users::destroy($user_id);
        $this->msg2session('success',["管理員編號 ".$user_id." 已成功刪除"]);

        return redirect('/users');
    }
}