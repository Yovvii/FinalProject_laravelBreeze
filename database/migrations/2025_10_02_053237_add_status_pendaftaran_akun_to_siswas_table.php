<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Tambahkan kolom status pendaftaran akun (default: pending)
            $table->enum('status_pendaftaran_akun', ['pending', 'completed'])
                  ->default('pending')
                  ->after('status_pendaftaran'); // Posisikan setelah kolom status_pendaftaran
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('status_pendaftaran_akun');
        });
    }
};