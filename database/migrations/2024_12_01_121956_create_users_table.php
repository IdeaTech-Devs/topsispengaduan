<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'satgas', 'pelapor']);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('satgas_id')->nullable();
            $table->unsignedBigInteger('pelapor_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('admin_id')
                  ->references('id')
                  ->on('admin')
                  ->onDelete('set null');

            $table->foreign('satgas_id')
                  ->references('id_satgas')
                  ->on('satgas')
                  ->onDelete('set null');

            $table->foreign('pelapor_id')
                  ->references('id_pelapor')
                  ->on('pelapor')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}; 