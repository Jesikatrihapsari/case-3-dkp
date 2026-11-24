<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses Login Manual
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email di database
        $user = DB::table('users')->where('email', $request->email)->first();

        // Verifikasi password menggunakan password_verify (sesuai ketentuan tugas)
        if ($user && password_verify($request->password, $user->password)) {
            // Simpan data ke session PHP manual
            session([
                'login_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email
            ]);

            return redirect()->route('products.index')->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    // Menampilkan Form Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses Register Manual
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Simpan data user baru dengan password yang di-hash menggunakan password_hash
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        // Hapus seluruh session
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}