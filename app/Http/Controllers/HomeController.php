<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // $username = $this->username();
        // dd($username);
        $user = User::where('email','123@123.com')->first();
        var_dump($request->cookie('password'));
        echo '<br>';
        $password = $request->cookie('password');
        dd(Hash::check("111111",$password));
        return view('home');
    }

    /**
     *  用户注册ajax验证
     *
     */
    public function reg(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email',trim($email))->first();

        if($user) {
            return response()->json([
                'status' => 0,
                'msg' => '邮箱已经注册'
            ]);
        } else {
            return response()->json([
                'status' => 1
            ]);
        }

    }
}
