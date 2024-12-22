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
        Schema::create('kemahasiswaan', function (Blueprint $table) {
            $table->id('id_kemahasiswaan');
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('telepon', 15);
            $table->string('foto_profil')->nullable();
            $table->enum('fakultas', [
                'Teknik', 
                'Hukum', 
                'Pertanian', 
                'Ilmu Sosial dan Ilmu Politik', 
                'Keguruan dan Ilmu Pendidikan', 
                'Ekonomi dan Bisnis', 
                'Kedokteran dan Ilmu Kesehatan', 
                'Matematika dan Ilmu Pengetahuan Alam'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kemahasiswaan');
    }
};