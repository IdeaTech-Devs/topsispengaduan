<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kasus_satgas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasus_id');
            $table->unsignedBigInteger('satgas_id');
            $table->enum('status_penanganan', ['Belum ditangani', 'Sedang ditangani', 'Selesai']);
            $table->text('catatan_penanganan')->nullable();
            $table->timestamp('mulai_penanganan')->nullable();
            $table->timestamp('selesai_penanganan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kasus_id')
                  ->references('id')
                ->on('kasus')
                ->onDelete('cascade');
                
            $table->foreign('satgas_id')
                ->references('id_satgas')
                ->on('satgas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasus_satgas');
    }
}; 