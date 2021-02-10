<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserPriv;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function validateLogin(Request $req)
    {
        $remember = true;
        if (Auth::attempt(['username' => $req->username, 'password' => $req->password], $remember)) {
            return redirect()->intended('/');
        }
        return redirect()->back()->with('error', 'failed');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/login');
    }
}
