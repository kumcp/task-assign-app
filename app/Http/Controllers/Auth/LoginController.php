<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
    
        $email = $request->email;
        $account = Account::where('email', $email)->first();

        if (!$account->active)
            return redirect('login')->withInput()->with('error', 'Tài khoản chưa được kích hoạt bởi quản trị viên');
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            
            return redirect('jobs.index');
        }

        return redirect('login')->withInput()->with('error', 'Tài khoản hoặc mật khẩu không chính xác');
    }


    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}