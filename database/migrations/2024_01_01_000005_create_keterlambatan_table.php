<?php
// database/migrations/2024_01_01_000005_create_keterlambatan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('keterlambatan', function (Blueprint $table) {
            $table->id('id_telat');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->onDelete('cascade');
            $table->datetime('waktu_datang');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keterlambatan');
    }
};
