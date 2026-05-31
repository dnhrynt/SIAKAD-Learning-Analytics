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
        Schema::create('nilai_tp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_siswa_id')->constrained('rombel_siswa')->onDelete('cascade');
            $table->foreignId('tujuan_pembelajaran_id')->constrained('tujuan_pembelajaran')->onDelete('cascade');
            $table->float('nilai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_tp');
    }
};
