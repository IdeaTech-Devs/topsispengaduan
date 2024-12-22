<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kriteria_topsis', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->string('nama_kriteria');
            $table->decimal('bobot', 3, 2);
            $table->enum('jenis', ['benefit', 'cost']);
            $table->timestamps();
        });

        Schema::create('nilai_kriteria_topsis', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->unsignedBigInteger('id_kriteria');
            $table->string('item');
            $table->integer('nilai');
            $table->timestamps();
            
            $table->foreign('id_kriteria')
                  ->references('id_kriteria')
                  ->on('kriteria_topsis')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_kriteria_topsis');
        Schema::dropIfExists('kriteria_topsis');
    }
}; 