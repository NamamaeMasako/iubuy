<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Session;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $RedirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login() {
        return view('auth.login');  
    }

    public function handleLogin(Request $request) {
        $this->validate($request,
            $rules = [
                'email' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha'
            ],
            $messages = [
                'email.required' => '帳號(Email) - 必填',
                'password.required' => '密碼 - 必填',
                'g-recaptcha-response.required' => '請驗證"我不是機器人"',
                'g-recaptcha-response.captcha' => '"我不是機器人"驗證失敗 - 重新確認',
            ]
        );


        $data = $request->only('email', 'password');

        if(Auth::attempt($data)){
            return redirect()->intended($this->RedirectTo); 
        }
        else{
            return back()->withErrors(['accountpwd_error'=>'帳號或密碼錯誤']);
        }

        return back()->withInput();
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
