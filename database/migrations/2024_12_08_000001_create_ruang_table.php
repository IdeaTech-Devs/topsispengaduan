<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruang', function (Blueprint $table) {
            $table->id('id_ruang');
            $table->string('nama_ruang', 100);
            $table->string('lokasi', 100);
            $table->string('kode_ruang', 50)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruang');
    }
}; 