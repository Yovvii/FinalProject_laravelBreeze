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
        Schema::create('spmb_statuses', function (Blueprint $table) {
            // Kita buat kolom string untuk menyimpan status ('active', 'closed', 'finished')
            $table->string('status')->default('active'); 
            // Kita tidak butuh ID atau timestamps karena hanya ada satu baris.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_statuses');
    }
};
