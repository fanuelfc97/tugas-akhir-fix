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
        Schema::create('sewa_lahans', function (Blueprint $table) {
            $table->string('no_kontrak')->primary();
            $table->string('koordinat_titik');
            $table->date('periode_awalsl');
            $table->date('periode_akhirsl');
            $table->string('dokumen_sl');

            $table->foreign('koordinat_titik')->references('koordinat_titik')->on('titik_reklames')->onDelete('cascade');
             // Store dimensions as a single string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_lahans');
    }
};