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
        Schema::create('sma_registration_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sma_registration_id');
            $table->string('file_path');
            $table->string('file_type', 50);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('sma_registration_id')->references('id')->on('sma_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sma_registration_files');
    }
};
