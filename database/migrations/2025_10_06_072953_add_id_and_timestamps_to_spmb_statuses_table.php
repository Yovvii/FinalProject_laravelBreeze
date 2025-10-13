<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb_statuses', function (Blueprint $table) {
            // Tambahkan kolom id sebagai Primary Key
            $table->id(); 
            // Tambahkan kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('spmb_statuses', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $table->dropTimestamps();
            $table->dropColumn('id');
        });
    }
};
