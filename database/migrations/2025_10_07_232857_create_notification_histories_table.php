<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type', 10); // success, error
            $table->string('message', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_histories');
    }
};