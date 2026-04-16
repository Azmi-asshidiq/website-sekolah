<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_siswa')
                  ->constrained('siswa', 'id_siswa')
                  ->onDelete('cascade');

            $table->foreignId('id_guru')
                  ->nullable()
                  ->constrained('guru', 'id_guru')
                  ->nullOnDelete();

            $table->date('tanggal');
            $table->string('jenis_pelanggaran', 100);
            $table->text('keterangan')->nullable();
            $table->text('sanksi')->nullable();
            $table->integer('poin')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};