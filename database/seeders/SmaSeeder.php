<?php

namespace Database\Seeders;

use App\Models\DataSma;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $smas = ['SMAN 1 Purbalingga','SMAN 2 Purbalingga', 'SMAN 1 Bukateja', 'SMAN 1 Kejobong'];

        foreach ($smas as $sma) {
            DataSma::firstOrCreate(['nama_sma' => $sma]);
        }
    }
}
