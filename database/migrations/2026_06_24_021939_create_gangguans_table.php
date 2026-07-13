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
        \Schema::create('gangguans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu_kejadian')->nullable();
            $table->string('id_laporan');
            $table->string('no_tiket');
            $table->string('ip_address');
            $table->string('gardu_induk');
            $table->enum('status', ['on_progress', 'paused', 'resolved'])->default('on_progress');
            $table->tinyInteger('tahapan')->unsigned()->default(1);
            $table->string('jenis_gangguan')->nullable();
            $table->enum('status_jaringan', ['UP', 'DOWN'])->default('DOWN');
            $table->string('foto_lokasi')->nullable();
            $table->string('foto_petugas')->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gangguans');
    }
};
