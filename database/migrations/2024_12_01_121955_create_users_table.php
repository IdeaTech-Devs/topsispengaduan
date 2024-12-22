<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'kemahasiswaan', 'satgas']);
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_kemahasiswaan')->nullable();
            $table->unsignedBigInteger('id_satgas')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_admin')
                  ->references('id_admin')
                  ->on('admin')
                  ->onDelete('set null');

            $table->foreign('id_kemahasiswaan')
                  ->references('id_kemahasiswaan')
                  ->on('kemahasiswaan')
                  ->onDelete('set null');

            $table->foreign('id_satgas')
                  ->references('id_satgas')
                  ->on('satgas')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};