<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelapor', function (Blueprint $table) {
            $table->id('id_pelapor'); // Primary Key
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 50);
            $table->string('unsur', 100);
            $table->string('melapor_sebagai', 50);
            $table->string('bukti_identitas', 100);
            $table->string('fakultas', 50);
            $table->string('departemen_prodi', 50)->nullable();
            $table->string('unit_kerja', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('no_wa', 15);
            $table->string('hubungan_korban', 50)->nullable();
            $table->index(['nama_lengkap', 'email']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelapor');
    }
}