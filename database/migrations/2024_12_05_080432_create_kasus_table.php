<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasus', function (Blueprint $table) {
            $table->id('id_kasus');
            $table->string('kode_pengaduan', 6)->unique();
            $table->unsignedBigInteger('id_kemahasiswaan')->nullable();
            $table->unsignedBigInteger('id_pelapor');
            $table->enum('jenis_masalah', ['bullying', 'kekerasan seksual', 'pelecehan verbal', 'diskriminasi', 'cyberbullying', 'lainnya']);
            $table->enum('urgensi', ['segera', 'dalam beberapa hari', 'tidak mendesak']);
            $table->enum('dampak', ['sangat besar', 'sedang', 'kecil']);
            $table->enum('status_pengaduan', ['perlu dikonfirmasi', 'dikonfirmasi', 'ditolak', 'proses satgas', 'selesai'])->default('perlu dikonfirmasi');
            $table->date('tanggal_konfirmasi')->nullable();
            $table->date('tanggal_pengaduan');
            $table->text('deskripsi_kasus');
            $table->string('bukti_kasus')->nullable();
            $table->string('asal_fakultas', 50);
            $table->string('penangan_kasus')->nullable();
            $table->text('catatan_penanganan')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kemahasiswaan')
                ->references('id_kemahasiswaan')
                ->on('kemahasiswaan')
                ->onDelete('set null');
                
            $table->foreign('id_pelapor')
                ->references('id_pelapor')
                ->on('pelapor')
                ->onDelete('cascade');

            // Indexes
            $table->index('id_kemahasiswaan');
            $table->index('id_pelapor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kasus');
    }
}