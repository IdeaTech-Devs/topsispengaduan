<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelapor', function (Blueprint $table) {
            $table->id('id_pelapor');
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 50);
            $table->enum('status_pelapor', ['staff', 'pengunjung']);
            $table->string('email', 100)->unique();
            $table->string('no_wa', 15);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelapor');
    }
}; 