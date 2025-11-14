<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_nip');
            $table->string('instansi');
            $table->string('layanan'); // Nama Layanan yang dipilih
            $table->string('keperluan')->nullable();
            $table->string('no_hp');
            $table->boolean('sudah_survey')->default(false); // Status apakah sudah mengisi survey
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};