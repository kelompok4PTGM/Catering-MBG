<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Superadmin
        User::create([
            'username' => 'superadmin',
            'email'    => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'Superadmin',
            'status'   => 'Aktif',
        ]);

        // 2. Akun Admin (Manager Catering Bunda Fadil)
        $adminFadil = User::create([
            'username' => 'bundafadil',
            'email'    => 'bundafadil@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'Admin',
            'status'   => 'Aktif',
        ]);

        // Sample Catering untuk Bunda Fadil
        DB::table('catering')->insert([
            'id_admin'      => $adminFadil->id,
            'nama_catering' => 'Catering Bunda Fadil',
            'deskripsi'     => 'Menyediakan aneka paket catering sehat, lezat, dan bergizi untuk program MBG.',
            'status'        => 'Aktif',
        ]);

        // 3. Akun User (Pembeli)
        User::create([
            'username' => 'pembeli1',
            'email'    => 'pembeli1@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'User',
            'status'   => 'Aktif',
        ]);
    }
}
