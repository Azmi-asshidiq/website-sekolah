<?php
// database/migrations/2024_01_01_000001_create_siswa_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nis', 20)->unique();
            $table->string('nama', 100);
            $table->string('kelas', 20);
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('jurusan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
