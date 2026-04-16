<?php
// database/migrations/2024_01_01_000002_create_guru_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->string('nip')->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            $table->string('jenis_kelamin', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
