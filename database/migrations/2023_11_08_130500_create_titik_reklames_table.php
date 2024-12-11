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
        Schema::create('titik_reklames', function (Blueprint $table) {
            $table->string('koordinat_titik')->primary();
            $table->index('koordinat_titik');
            $table->string('nama_titik');
            $table->string('ilustrasi_titik');
            $table->string('status_titik');
            $table->string('jenis_penerangan');
            $table->integer('jumlah_lampu');
            $table->float('panjang');
            $table->float('lebar');
            $table->float('muka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_reklames');
    }

};
