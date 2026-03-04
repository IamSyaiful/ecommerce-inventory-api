<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau Password salah'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => Auth::guard('api')->user(),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        ], 200);
    }
}
