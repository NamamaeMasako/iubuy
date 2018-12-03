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
    protected $redirectTo = '/index';

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
                //'g-recaptcha-response' => 'required|captcha'
            ],
            $messages = [
                //'g-recaptcha-response.required' => '請驗證我不是機器人'
            ]
        );


        $data = $request->only('account', 'password');

        if(Auth::attempt($data)){
            if(Auth::user()->premission == 0){
                Auth::logout();
                Session::flush();
                return back()->withErrors(['accountpwd_error'=>'此帳號已被停權']);
            }else{
                return redirect()->intended($this->redirectTo);
            }
        }
        else{
            return back()->withErrors(['accountpwd_error'=>'帳號或密碼錯誤']);
        }

        return back()->withInput();
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect('/index');
    }
}
