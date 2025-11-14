<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survei_kepuasan', function (Blueprint $table) {
            $table->id();
            // Kunci asing ke tabel pengunjung (opsional, tergantung alur Anda)
            $table->foreignId('pengunjung_id')->nullable()->constrained('pengunjung')->onDelete('set null');

            // Data Demografi (Bagian 1)
            $table->integer('usia');
            $table->string('jenis_kelamin');
            $table->string('pendidikan_terakhir');
            $table->string('pekerjaan');
            $table->string('jenis_layanan_diterima');

            // Jawaban Pertanyaan (Q1-Q9 dari form)
            $table->integer('q1_persyaratan');
            $table->integer('q2_prosedur');
            $table->integer('q3_waktu');
            $table->integer('q4_biaya');
            $table->integer('q5_produk');
            $table->integer('q6_kompetensi_petugas');
            $table->integer('q7_perilaku_petugas');
            $table->integer('q8_penanganan_pengaduan');
            $table->integer('q9_sarana');
            $table->text('saran_masukan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasan');
    }
};