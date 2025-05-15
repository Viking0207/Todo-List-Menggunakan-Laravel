<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\users;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
      // Halaman register
    public function showRegisterForm()
    {
        return view('register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_user,email',
            'pass' => 'required|string|min:6|confirmed',
        ]);

        $user = users::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pass' => Hash::make($request->pass),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.index')->with('success', 'Berhasil register dan login!');
    }

    // Halaman login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pass' => 'required|string',
        ]);

        $user = users::where('email', $request->email)->first();

        if ($user && Hash::check($request->pass, $user->pass)) {
            Auth::login($user);
            return redirect()->route('dashboard.index')->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home.index')->with('success', 'Berhasil logout');
    }
}
