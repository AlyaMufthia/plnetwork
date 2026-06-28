<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->change();
            $table->string('jenis_gangguan')->nullable()->after('tahapan');
            $table->enum('status_jaringan', ['UP', 'DOWN'])->default('DOWN')->after('jenis_gangguan');
        });
    }

    public function down(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {
            $table->dropColumn(['jenis_gangguan', 'status_jaringan']);
        });
    }
};