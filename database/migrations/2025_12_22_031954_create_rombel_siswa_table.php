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
        Schema::create('rombel_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombongan_belajar')->onDelete('cascade');
            $table->enum('status', ['aktif', 'naik', 'tinggal', 'drop-out', 'lulus'])->default('aktif');
            $table->timestamps();

            $table->unique(['rombel_id', 'siswa_id']);
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel_siswa');
    }
};
