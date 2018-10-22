<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';
    private $users_img_dir = 'upload/users/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function register() {
        return view('auth.register');
    }

    public function handleRegister(Request $request) {
        $this->validate(
            $request, $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'agreement' => 'accepted'
            ],
            $messages = [
                'name.required' => '使用者名稱 - 必填',
                'name.max' => '使用者名稱 - 字數過多',
                'email.required' => '帳號(Email) - 必填',
                'email.email' => '帳號(Email) - 格式錯誤',
                'email.max' => '帳號(Email) - 字數過多',
                'email.unique' => '帳號(Email) - 此帳號已存在',
                'password.required' => '密碼 - 必填',
                'password.min' => '密碼 - 至少六位英數字',
                'password.confirmed' => '再次確認密碼 - 確認失敗',
                'agreement.accepted' => '請同意提供個人資料',
            ]
        );
        $user_id = time();
        $new_tb_User = new User();
        $new_tb_User->id = $user_id;
        $new_tb_User->name = $request->name;
        $new_tb_User->email = $request->email;
        $new_tb_User->password = bcrypt($request->password);
        $new_tb_User->admin = 0;
        $imgName = $user_id.'.jpg';
        \File::makeDirectory($this->users_img_dir,0775,true,true);
        \Image::make($this->users_img_dir.'default_user.jpg')->save($this->users_img_dir.$imgName);
        $new_tb_User->avator = $imgName;
        $new_tb_User->save();

        return redirect('/');
    }
}
