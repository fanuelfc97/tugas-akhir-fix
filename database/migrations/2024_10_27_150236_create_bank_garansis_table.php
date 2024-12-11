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
        Schema::create('bank_garansis', function (Blueprint $table) {
            $table->string('no_jaminan')->primary();
            $table->string('koordinat_titik');
            $table->date('periode_awalbg');
            $table->date('periode_akhirbg');
            $table->string('dokumen_bg');
             // Store dimensions as a single string
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
        Schema::dropIfExists('bank_garansis');
    }
};