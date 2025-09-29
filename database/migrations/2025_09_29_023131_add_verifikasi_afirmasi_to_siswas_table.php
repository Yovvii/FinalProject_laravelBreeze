<?php
// database/migrations/XXXX_XX_XX_XXXXXX_add_verifikasi_afirmasi_to_siswas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Tambahkan kolom untuk status verifikasi Afirmasi
            // Sesuaikan enum jika Anda menggunakan tipe data yang berbeda
            $table->enum('verifikasi_afirmasi', ['pending', 'terverifikasi', 'ditolak'])
                  ->default('pending')
                  ->after('verifikasi_sertifikat'); 
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('verifikasi_afirmasi');
        });
    }
};