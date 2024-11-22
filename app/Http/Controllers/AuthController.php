<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function attempt(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    $redirect_url = route('admin.dashboard');
                    break;
                case 'ps':
                    $redirect_url = route('ps.dashboard');
                    break;
                default:
                    $redirect_url = route('login');
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect_url' => $redirect_url,
                'user' => $user
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function dashboard()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.dashboard.index');
            case 'ps':
                return view('ps.dashboard.index');
            default:
                return redirect()->route('login');
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
