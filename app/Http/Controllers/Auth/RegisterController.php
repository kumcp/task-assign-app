<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Account;
use App\Models\Department;
use App\Models\Staff;

use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }


    public function store(RegisterRequest $request) 
    {

        $newStaff = Staff::create(['name' => $request->name]);

        $newAccount = new Account([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'staff_id' => $newStaff->id, 
        ]);

        $newAccount->save();

        return redirect('login')->with('success', 'Tạo tài khoản thành công');

    }
}
