<?php
// database/migrations/2024_01_01_000003_create_piket_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('piket', function (Blueprint $table) {
            $table->id('id_piket');
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->cascadeOnDelete();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piket');
    }
};
