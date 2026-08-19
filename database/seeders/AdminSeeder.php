<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Membuat akun administrator.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'nama' => 'Admin',
                'alamat' => 'Buana',
                'no_hp' => '081234567890',
                'role_user' => 'admin',
                'password' => Hash::make('admin12345'),
            ]
        );
    }
}