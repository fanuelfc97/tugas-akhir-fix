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
        Schema::create('asuransis', function (Blueprint $table) {
            $table->string('no_polis')->primary();
            $table->string('koordinat_titik');
            $table->date('periode_awalas');
            $table->date('periode_akhiras');
            $table->string('dokumen_polis');
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
        Schema::dropIfExists('asuransis');
    }
};
