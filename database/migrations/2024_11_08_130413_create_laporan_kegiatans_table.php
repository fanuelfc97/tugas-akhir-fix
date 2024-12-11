<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_kegiatans', function (Blueprint $table) {
            $table->string('no_laporan')->primary();
            $table->string('koordinat_titik');
            $table->string('jenis_kegiatan');
            $table->date('tanggal_kegiatan');
            $table->string('id_pegawai');
            $table->string('laporan');
            $table->timestamps();

            $table->foreign('koordinat_titik')->references('koordinat_titik')->on('titik_reklames')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kegiatans');
    }
};