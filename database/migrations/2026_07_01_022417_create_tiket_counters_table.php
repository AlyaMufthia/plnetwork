<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('last_number')->default(0);
            $table->timestamps();
        });

        // seed 1 baris awal
        DB::table('tiket_counters')->insert(['last_number' => 0]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_counters');
    }
};