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
            $table->string('id_pegawai');
            $table->string('username')->primary();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jabatan');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            $table->foreign('jabatan')->references('jabatan')->on('pegawais')->onDelete('cascade');

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
