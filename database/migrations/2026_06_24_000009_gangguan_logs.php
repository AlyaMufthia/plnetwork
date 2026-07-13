<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom 'foto' ke tabel gangguan_logs.
     * Kolom ini dipakai untuk foto opsional per-catatan di Log Aktivitas
     * (lihat GangguanLog::$fillable, RiwayatController::update(), dan
     * input logs[i][foto] di riwayat-update.blade.php).
     */
    public function up(): void
    {
        Schema::create('gangguan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gangguan_id');
            $table->date('tanggal');
            $table->tinyInteger('tahapan')->unsigned()->default(1);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gangguan_logs', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};