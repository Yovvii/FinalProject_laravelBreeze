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
            // Tambahkan kolom status_penerimaan, defaultnya bisa null
            // Nilai yang akan disimpan: 'diterima', 'ditolak', atau null (belum ditentukan)
            $table->enum('status_penerimaan', ['diterima', 'ditolak'])->nullable()->after('status_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Ini berfungsi untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('status_penerimaan');
        });
    }
};
