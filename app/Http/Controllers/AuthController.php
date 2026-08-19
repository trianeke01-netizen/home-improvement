<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProfileTeknisi;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman registrasi
     */
    public function showRegister()
    {
        $kategori = Category::with('subCategories')->get();

        return view('auth.register', compact('kategori'));
    }

    /**
     * Proses registrasi
     */
    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DASAR
        |--------------------------------------------------------------------------
        */

        $rules = [
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'alamat' => [
                'required',
                'string',
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20',
            ],

            'role_user' => [
                'required',
                'in:pelanggan,teknisi',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | VALIDASI KHUSUS TEKNISI
        |--------------------------------------------------------------------------
        */

        if ($request->role_user === 'teknisi') {

            $rules['id_sub_kategori'] = [
                'required',
                'exists:sub_categories,id_sub_kategori',
            ];

            // Foto diri WAJIB untuk teknisi
            $rules['foto_diri'] = [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ];

            // KTP masih opsional
            $rules['ktp'] = [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ];

            // Portofolio masih opsional
            $rules['portofolio'] = [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI REQUEST
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate($rules);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        $user = DB::transaction(function () use ($validated, $request) {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN USER
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'role_user' => $validated['role_user'],
                'password' => Hash::make($validated['password']),
            ]);


            /*
            |--------------------------------------------------------------------------
            | JIKA TEKNISI
            |--------------------------------------------------------------------------
            */

            if ($validated['role_user'] === 'teknisi') {

                /*
                |--------------------------------------------------------------------------
                | AMBIL SUBKATEGORI
                |--------------------------------------------------------------------------
                */

                $subKategori = SubCategory::findOrFail(
                    $validated['id_sub_kategori']
                );


                /*
                |--------------------------------------------------------------------------
                | UPLOAD FOTO DIRI
                |--------------------------------------------------------------------------
                */

                $fotoDiriPath = $request->file('foto_diri')->store(
                    'teknisi/foto-diri',
                    'public'
                );


                /*
                |--------------------------------------------------------------------------
                | UPLOAD KTP
                |--------------------------------------------------------------------------
                */

                $ktpPath = null;

                if ($request->hasFile('ktp')) {
                    $ktpPath = $request->file('ktp')->store(
                        'teknisi/ktp',
                        'public'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | UPLOAD PORTOFOLIO
                |--------------------------------------------------------------------------
                */

                $portofolioPath = null;

                if ($request->hasFile('portofolio')) {
                    $portofolioPath = $request->file('portofolio')->store(
                        'teknisi/portofolio',
                        'public'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN PROFILE TEKNISI
                |--------------------------------------------------------------------------
                */

                ProfileTeknisi::create([
                    'id_user' => $user->id_user,

                    'id_kategori' => $subKategori->id_kategori,

                    'id_sub_kategori' => $subKategori->id_sub_kategori,

                    'ktp' => $ktpPath,

                    'foto_diri' => $fotoDiriPath,

                    'portofolio' => $portofolioPath,

                    'status_verifikasi' => 'Menunggu',
                ]);
            }


            return $user;
        });


        /*
        |--------------------------------------------------------------------------
        | LOGIN OTOMATIS
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        return redirect()->route('dashboard');
    }


    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }


    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);


        if (
            Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            $request->session()->regenerate();

            return redirect()->intended(
                route('dashboard')
            );
        }


        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}