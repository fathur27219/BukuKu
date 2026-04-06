<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ===== Halaman Login =====
    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    public function showSiswaLogin()
    {
        return view('auth.login-siswa');
    }

    // ===== LOGIN ADMIN =====
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }

        if ($user->role !== 'admin') {
            return back()->withErrors(['login' => 'Akun ini bukan admin'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/transactions'); // ✅ langsung ke admin
    }

    // ===== LOGIN SISWA =====
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }

        if ($user->role !== 'siswa') {
            return back()->withErrors(['login' => 'Akun ini bukan siswa'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/siswa/books'); // ✅ siswa ke books
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ===== FORM REGISTER =====
    public function showRegister()
    {
        return view('auth.register');
    }

    // ===== PROSES REGISTER =====
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:3|confirmed'
        ]);

        // ✅ buat user saja
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'siswa'
        ]);

        return redirect('/login-siswa')->with('success', 'Registrasi berhasil, tunggu aktivasi dari admin');
    }
}
