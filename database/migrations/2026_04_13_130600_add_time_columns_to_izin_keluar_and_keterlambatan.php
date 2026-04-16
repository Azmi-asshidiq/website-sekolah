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
        // Add missing columns to izin_keluar table
        if (Schema::hasTable('izin_keluar')) {
            Schema::table('izin_keluar', function (Blueprint $table) {
                if (!Schema::hasColumn('izin_keluar', 'waktu_keluar')) {
                    $table->datetime('waktu_keluar')->nullable()->after('alasan');
                }
                if (!Schema::hasColumn('izin_keluar', 'waktu_kembali')) {
                    $table->datetime('waktu_kembali')->nullable()->after('waktu_keluar');
                }
                if (!Schema::hasColumn('izin_keluar', 'status')) {
                    $table->string('status', 20)->default('pending')->after('waktu_kembali');
                }
            });
        }

        // Add missing columns to keterlambatan table
        if (Schema::hasTable('keterlambatan')) {
            Schema::table('keterlambatan', function (Blueprint $table) {
                if (!Schema::hasColumn('keterlambatan', 'waktu_datang')) {
                    $table->datetime('waktu_datang')->nullable()->after('tanggal');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop columns from izin_keluar
        if (Schema::hasTable('izin_keluar')) {
            Schema::table('izin_keluar', function (Blueprint $table) {
                $columns_to_drop = [];
                if (Schema::hasColumn('izin_keluar', 'status')) {
                    $columns_to_drop[] = 'status';
                }
                if (Schema::hasColumn('izin_keluar', 'waktu_kembali')) {
                    $columns_to_drop[] = 'waktu_kembali';
                }
                if (Schema::hasColumn('izin_keluar', 'waktu_keluar')) {
                    $columns_to_drop[] = 'waktu_keluar';
                }
                if (!empty($columns_to_drop)) {
                    $table->dropColumn($columns_to_drop);
                }
            });
        }

        // Drop columns from keterlambatan
        if (Schema::hasTable('keterlambatan')) {
            Schema::table('keterlambatan', function (Blueprint $table) {
                if (Schema::hasColumn('keterlambatan', 'waktu_datang')) {
                    $table->dropColumn('waktu_datang');
                }
            });
        }
    }
};
