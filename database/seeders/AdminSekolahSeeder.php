<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user admin sudah ada
        if (User::where('email', 'admin@sekolah.com')->doesntExist()) {
            User::create([
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.com',
                'password' => Hash::make('admin123'), // Password dienkripsi dengan aman
                'role' => 'admin_sekolah',
            ]);
        }
    }
}
