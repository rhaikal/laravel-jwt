<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $token = Auth::attempt($credentials);
        if(!$token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 60 * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Log out success!'], 200);
    }

    public function refresh()
    {
        return response()->json([
            'access_token' => Auth::refresh(),
            'token_type' => 'Bearer',
            'expires_in' => 60 * 60
        ]);
    }

    public function data()
    {
        return response()->json([Auth::user()]);
    }
}
