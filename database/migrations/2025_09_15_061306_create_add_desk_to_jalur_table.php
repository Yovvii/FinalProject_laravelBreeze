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
        Schema::table('jalur_pendaftarans', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('nama_jalur_pendaftaran');
            $table->text('deskripsi')->nullable()->after('logo');
        });
    }

    /**
     * Kembali ke keadaan semula.
     */
    public function down(): void
    {
        Schema::table('jalur_pendaftarans', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('deskripsi');
        });
    }
};