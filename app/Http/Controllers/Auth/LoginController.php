<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm(Request $request)
    {
        // 获取cookie
        if($request->cookie('autoLogin')) {
            $username = $this->username();
            if($request->cookie($username)) {
                $user_name = $request->cookie($username);
            } else {
                return view('auth.login');
            }

            $user = User::where($username,$user_name)->first();

            if($user) {
                Auth::guard('web')->login($user);
                return redirect('/');
            }
        }
        return view('auth.login');
        
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->attempt($this->credentials($request))) {
            // 7天cookie免登陆
            if($request->autologin) {
                $username = $this->username();

                $request->session()->regenerate();

                $this->clearLoginAttempts($request);

                \Cookie::queue($username,$request->$username,60*24*7);
                \Cookie::queue('autoLogin',1,60*24*7);
                return  redirect('/');
            }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 退出
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        \Cookie::queue('autoLogin',0);

        return redirect('/');
    }
}
