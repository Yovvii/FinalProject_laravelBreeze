<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // Pastikan tabel ada sebelum dihapus untuk menghindari error
        if (Schema::hasTable('student_activities')) {
            Schema::drop('student_activities');
            // Jika Anda mendefinisikan foreign key ke 'siswas', 
            // pastikan tabel 'siswas' tidak dihapus di sini.
        }
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        // Biarkan kosong, karena tujuan migrasi ini adalah penghapusan.
    }
};