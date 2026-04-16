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
        // Add hari column to piket table if it doesn't exist
        if (Schema::hasTable('piket')) {
            Schema::table('piket', function (Blueprint $table) {
                if (!Schema::hasColumn('piket', 'hari')) {
                    $table->string('hari', 20)->nullable()->after('id_guru');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('piket')) {
            Schema::table('piket', function (Blueprint $table) {
                if (Schema::hasColumn('piket', 'hari')) {
                    $table->dropColumn('hari');
                }
            });
        }
    }
};
