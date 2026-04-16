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
        Schema::create('jadwal_piket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_guru')
                  ->constrained('guru', 'id_guru')
                  ->onDelete('cascade');

            $table->string('hari', 20);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('semester', 20);
            $table->year('tahun_ajaran');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_piket');
    }
};
