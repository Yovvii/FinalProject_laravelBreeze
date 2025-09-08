<?php

namespace Database\Seeders;

use App\Models\JalurPendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jalur_pendaftaran = ['Prestasi', 'Afirmasi', 'Domisili'];

        foreach ($jalur_pendaftaran as $jalur) {
            JalurPendaftaran::firstOrCreate(['nama_jalur_pendaftaran' => $jalur]);
        }
    }
}
