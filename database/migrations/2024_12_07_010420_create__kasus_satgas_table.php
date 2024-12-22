<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kasus_satgas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kasus');
            $table->unsignedBigInteger('id_satgas');
            $table->date('tanggal_tindak_lanjut');
            $table->date('tanggal_tindak_selesai')->nullable();
            $table->enum('status_tindak_lanjut', ['selesai', 'proses']);
            
            // Primary key
            $table->primary(['id_kasus', 'id_satgas']);
            
            // Foreign keys
            $table->foreign('id_kasus')
                ->references('id_kasus')
                ->on('kasus')
                ->onDelete('cascade');
                
            $table->foreign('id_satgas')
                ->references('id_satgas')
                ->on('satgas')
                ->onDelete('cascade');
                
            // Index
            $table->index(['id_kasus', 'id_satgas']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasus_satgas');
    }
}; 