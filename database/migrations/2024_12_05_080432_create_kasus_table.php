<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kasus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelapor_id');
            $table->string('no_pengaduan')->unique();
            $table->string('judul_pengaduan');
            $table->text('deskripsi');
            $table->string('lokasi_fasilitas');
            $table->string('jenis_fasilitas');
            $table->enum('tingkat_urgensi', ['Rendah', 'Sedang', 'Tinggi']);
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_satgas')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->string('foto_penanganan')->nullable();
            $table->timestamp('tanggal_pengaduan');
            $table->timestamp('tanggal_penanganan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();
                
            $table->foreign('pelapor_id')
                ->references('id_pelapor')
                ->on('pelapor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasus');
    }
};