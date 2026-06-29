<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {

            if (!Schema::hasColumn('gangguans', 'waktu_kejadian')) {
                $table->dateTime('waktu_kejadian')->nullable();
            }

            if (!Schema::hasColumn('gangguans', 'tahapan')) {
                $table->string('tahapan')->nullable();
            }

            if (!Schema::hasColumn('gangguans', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }

            if (!Schema::hasColumn('gangguans', 'status_jaringan')) {
                $table->enum('status_jaringan', ['UP', 'DOWN'])
                    ->default('DOWN');
            }

            if (!Schema::hasColumn('gangguans', 'jenis_gangguan')) {
                $table->string('jenis_gangguan')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_kejadian',
                'tahapan',
                'ip_address',
                'status_jaringan',
                'jenis_gangguan'
            ]);
        });
    }
};