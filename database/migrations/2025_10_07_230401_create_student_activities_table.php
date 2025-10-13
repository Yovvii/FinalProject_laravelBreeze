<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade'); // Siswa mana yang melakukan aksi
            $table->string('aksi'); // Contoh: 'data_csubmitted', 'data_edited', 'berkas_tarik'
            $table->string('deskripsi')->nullable(); // Deskripsi detail aksi (misal: "Mengubah alamat dari X ke Y")
            $table->text('data_sebelumnya')->nullable(); // Opsional: data sebelum diubah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_activities');
    }
};