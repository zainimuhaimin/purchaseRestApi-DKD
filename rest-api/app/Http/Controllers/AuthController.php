<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'unique:users,email'],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password']
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ]);
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password_confirm'))
        ]);

        return response([
            'message' => 'success'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ]);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response([
                'invalid' => 'invalid credential'
            ]);
        }

        $user = Auth::user();
        $token = $request->user()->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); //1day

        return response([
            'message' => 'success',
            'token' => $token,
            'user' => $user
        ])->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('jwt');
        $request->user()->tokens()->delete();

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
