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
        Schema::create('jenis_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tujuan_pembelajaran_id')->constrained('tujuan_pembelajaran')->onDelete('cascade');
            $table->string('nama_jenis');
            $table->float('bobot')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_penilaian');
    }
};
