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
        Schema::create('satgas', function (Blueprint $table) {
            $table->id('id_satgas');
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('telepon', 15);
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satgas');
    }
};