<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hien thi trang dang ky
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xu ly dang ky tai khoan
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('movies.index');
    }

    // Hien thi trang dang nhap
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xu ly dang nhap
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(
                route('movies.index')
            );
        }

        return back()
            ->withErrors([
                'email' => 'Email hoac mat khau khong dung.',
            ])
            ->withInput($request->only('email'));
    }

    // Xu ly dang xuat
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('movies.index');
    }
}
