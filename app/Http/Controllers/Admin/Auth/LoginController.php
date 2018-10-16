<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    protected $redirectTo = '/dash';

    public function showLoginForm()
    {
    	return view('admin.login');
    }

    /**
     * 重写 Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    protected function username()
    {
        return 'name';
    }

    public function login(Request $request)
    {
        if($this->guard()->attempt($this->credentials($request))) {

            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return redirect('/dash');
        }
    }

    /**
     * 重写 Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        return redirect('/login');
    }
}
