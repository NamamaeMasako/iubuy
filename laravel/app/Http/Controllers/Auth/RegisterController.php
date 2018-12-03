<?php

namespace App\Http\Controllers\Auth;

use App\Members;
use App\MemberProfiles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/index';
    private $members_img_dir = 'webmgr/upload/members/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register() {
        return view('auth.register');
    }

    public function handleRegister(Request $request) {
        $this->validate(
            $request, $rules = [
                'account' => 'required|min:6|max:50|unique:members',
                'name' => 'required|max:50|unique:members',
                'gender' => 'required',
                'email' => 'required|email|max:255|unique:members',
                'phone' => 'required|max:45|unique:members',
                'password' => 'required|min:6|confirmed',
                'agreement' => 'accepted',
                'g-recaptcha-response' => 'required|captcha'
            ],
            $messages = [
                'account.required' => '帳號 - 必填',
                'account.max' => '帳號 - 字數過多',
                'account.min' => '帳號 - 至少六位英數字',
                'account.unique' => '帳號 - 此暱稱已被使用',
                'name.required' => '暱稱 - 必填',
                'name.max' => '暱稱 - 字數過多',
                'name.unique' => '暱稱 - 此暱稱已被使用',
                'gender.required' => '性別 - 必填',
                'email.required' => '電子信箱 - 必填',
                'email.email' => '電子信箱 - 格式錯誤',
                'email.max' => '電子信箱 - 字數過多',
                'email.unique' => '電子信箱 - 此電子信箱已被使用',
                'phone.required' => '手機 - 必填',
                'phone.max' => '手機 - 字數過多',
                'phone.unique' => '手機 - 此手機已被使用',
                'password.required' => '密碼 - 必填',
                'password.min' => '密碼 - 至少六位英數字',
                'password.confirmed' => '再次確認密碼 - 確認失敗',
                'agreement.accepted' => '請同意提供個人資料',
                'g-recaptcha-response.required' => '請驗證"我不是機器人"',
                'g-recaptcha-response.captcha' => '"我不是機器人"驗證失敗 - 重新驗證',
            ]
        );
        $new_tb_Member = new Members();
        $new_tb_Member->account = $request->account;
        $new_tb_Member->name = $request->name;
        $new_tb_Member->email = $request->email;
        $new_tb_Member->phone = $request->phone;
        $new_tb_Member->password = bcrypt($request->password);
        $new_tb_Member->admin = 0;
        $new_tb_Member->premission = 1;
        $new_tb_Member->save();
        $new_tb_MemberProfiles = new MemberProfiles();
        $new_tb_MemberProfiles->members_account = $new_tb_Member->account;
        $new_tb_MemberProfiles->gender = $request->gender;
        $new_tb_MemberProfiles->save();
        
        return view('success');
    }
}
