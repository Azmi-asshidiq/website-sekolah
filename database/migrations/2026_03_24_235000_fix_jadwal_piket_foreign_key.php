<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_piket', function (Blueprint $table) {
            $table->dropForeign(['id_guru']);
            $table->dropColumn('id_guru');
        });

        Schema::table('jadwal_piket', function (Blueprint $table) {
            $table->unsignedBigInteger('id_guru');
            $table->foreign('id_guru')
                  ->references('id_guru')
                  ->on('guru')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_piket', function (Blueprint $table) {
            $table->dropForeign(['id_guru']);
            $table->dropColumn('id_guru');
        });

        Schema::table('jadwal_piket', function (Blueprint $table) {
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->onDelete('cascade');
        });
    }
};
