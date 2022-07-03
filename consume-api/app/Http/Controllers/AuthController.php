<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Input;

class AuthController extends Controller
{
    public function register()
    {
        if (Session::get('isToken')) {
            return  redirect()->to('/dashboard');
        }
        $data = [
            'title' => 'Register'
        ];
        return view('auth.pages.register', $data);
    }

    public function login()
    {
        if (Session::get('isToken')) {
            return  redirect()->to('/dashboard');
        }
        // dd(Session::get('isToken'));
        // Session::forget('isToken');
        $data = [
            'title' => 'Login',
            'regis' => redirect()->to('/register')
        ];
        return view('auth.pages.login', $data);
    }

    public function setToken(Request $request)
    {
        $isToken = $request->input('id');
        $username = $request->input('username');
        Session::put('isToken', $isToken);
        Session::put('username', $username);
        return response()->json(['success' => 'success'], 200);
    }

    public function logout()
    {
        Session::forget('isToken');
        Session::forget('username');
        return response()->json(['success' => 'success'], 200);
    }
}
