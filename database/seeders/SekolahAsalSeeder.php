<?php

namespace Database\Seeders;

use App\Models\SekolahAsal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SekolahAsalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = ['SMPN 1 Kejobong','SMPN 2 Kejobong', 'SMPN 1 Bukateja', 'SMPN 2 Bukateja'];

        foreach ($sekolahs as $sekolah) {
            SekolahAsal::firstOrCreate(['nama_sekolah' => $sekolah]);
        }
    }
}
