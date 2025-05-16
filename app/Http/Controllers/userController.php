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
        // Validasi: gunakan 'password' dan 'password_confirmation'
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_user,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru, kolom di DB tetap 'pass'
        $user = users::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
        // Validasi: gunakan 'password'
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = users::where('email', $request->email)->first();

        // Cek password dengan kolom 'pass'
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard.index')->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard.index')->with('success', 'Berhasil logout');
    }
}
