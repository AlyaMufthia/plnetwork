<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('gangguans', function (Blueprint $table) {
        $table->string('foto_lokasi')->nullable()->after('tahapan');
        $table->string('foto_petugas')->nullable()->after('foto_lokasi');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {
        $table->dropColumn(['foto_lokasi', 'foto_petugas']);
        });
    }
};
