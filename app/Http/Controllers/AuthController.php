<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProfileTeknisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        $kategori = Category::all();
        return view('auth.register', compact('kategori'));
    }

    public function register(Request $request)
    {
        $rules = [
            'nama'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'alamat'    => ['required', 'string'],
            'no_hp'     => ['required', 'string', 'max:20'],
            'role_user' => ['required', 'in:pelanggan,teknisi'],
            'password'  => ['required', 'confirmed', Password::min(8)],
        ];

        // Validasi tambahan khusus kalau daftar sebagai teknisi
        if ($request->role_user === 'teknisi') {
            $rules['id_kategori'] = ['required', 'exists:categories,id_kategori'];
            $rules['ktp']         = ['nullable', 'image', 'max:2048'];       // maks 2MB
            $rules['portofolio']  = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120']; // maks 5MB
        }

        $validated = $request->validate($rules);

        // Simpan User + (kalau teknisi) ProfileTeknisi dalam satu transaksi database.
        // Kalau salah satu gagal, semuanya dibatalkan (tidak ada data "setengah jadi").
        $user = DB::transaction(function () use ($validated, $request) {

            $user = User::create([
                'nama'      => $validated['nama'],
                'email'     => $validated['email'],
                'alamat'    => $validated['alamat'],
                'no_hp'     => $validated['no_hp'],
                'role_user' => $validated['role_user'],
                'password'  => Hash::make($validated['password']),
            ]);

            if ($validated['role_user'] === 'teknisi') {
                $ktpPath = $request->hasFile('ktp')
                    ? $request->file('ktp')->store('teknisi/ktp', 'public')
                    : null;

                $portofolioPath = $request->hasFile('portofolio')
                    ? $request->file('portofolio')->store('teknisi/portofolio', 'public')
                    : null;

                ProfileTeknisi::create([
                    'id_user'           => $user->id_user,
                    'id_kategori'       => $validated['id_kategori'],
                    'id_sub_kategori'   => null, // dilengkapi nanti
                    'ktp'               => $ktpPath,
                    'foto_diri'         => null, // dilengkapi nanti
                    'portofolio'        => $portofolioPath,
                    'status_verifikasi' => 'Menunggu',
                ]);
            }

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}