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
    public function showRegister()
    {
        $kategori = Category::with('subCategories')->get();

        return view('auth.register', compact('kategori'));
    }

    public function register(Request $request)
    {

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

        if ($request->role_user === 'teknisi') {

            $rules['id_sub_kategori'] = [
                'required',
                'exists:sub_categories,id_sub_kategori',
            ];

            $rules['foto_diri'] = [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ];

            $rules['ktp'] = [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ];

            $rules['portofolio'] = [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ];
        }


        $messages = [
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email lain atau login.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'foto_diri.required' => 'Foto diri wajib diunggah untuk pendaftaran teknisi.',
            'id_sub_kategori.required' => 'Layanan keahlian wajib dipilih untuk teknisi.',
        ];

        $validated = $request->validate($rules, $messages);

        $user = DB::transaction(function () use ($validated, $request) {

            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'role_user' => $validated['role_user'],
                'password' => Hash::make($validated['password']),
            ]);

            if ($validated['role_user'] === 'teknisi') {

                $subKategori = SubCategory::findOrFail(
                    $validated['id_sub_kategori']
                );

                $fotoDiriPath = $request->file('foto_diri')->store(
                    'teknisi/foto-diri',
                    'public'
                );

                $ktpPath = null;

                if ($request->hasFile('ktp')) {
                    $ktpPath = $request->file('ktp')->store(
                        'teknisi/ktp',
                        'public'
                    );
                }

                $portofolioPath = null;

                if ($request->hasFile('portofolio')) {
                    $portofolioPath = $request->file('portofolio')->store(
                        'teknisi/portofolio',
                        'public'
                    );
                }

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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar di sistem.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil diperbarui. Silakan masuk menggunakan password baru Anda.');
    }
}