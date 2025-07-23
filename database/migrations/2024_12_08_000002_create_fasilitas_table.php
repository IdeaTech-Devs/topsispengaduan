<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');
            $table->unsignedBigInteger('ruang_id');
            $table->string('nama_fasilitas', 100);
            $table->string('jenis_fasilitas', 50);
            $table->string('kode_fasilitas', 50)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('ruang_id')
                  ->references('id_ruang')
                  ->on('ruang')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fasilitas');
    }
}; 