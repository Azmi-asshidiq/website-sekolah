<?php
// database/migrations/2024_01_01_000004_create_izin_keluar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('izin_keluar', function (Blueprint $table) {
            $table->id('id_izin');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->onDelete('cascade');
            $table->text('alasan');
            $table->datetime('waktu_keluar');
            $table->datetime('waktu_kembali')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_keluar');
    }
};
