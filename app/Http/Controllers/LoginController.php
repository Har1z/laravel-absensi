<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Route;

class LoginController extends Controller
{
    public function showLoginPage() {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }else{
            return view('pages.login');
        }
    }

    public function login(Request $request) {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = $request->has('rememberme'); // true if remember me is checked

        if (Auth::attempt($data, $remember)) {
            return redirect(route('dashboard'));
        } else {
            Session::flash('error', 'Email or password is incorrect');
            return redirect(route('login'));
        }

    }

    public function logout() {
        Auth::logout();
        return redirect(route('login'));
    }
}
