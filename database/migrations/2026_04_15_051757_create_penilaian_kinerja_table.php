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
        Schema::create('penilaian_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTugas');
            $table->unsignedBigInteger('idMahasiswa');
            $table->double('nilaiAwal');
            $table->double('penalti')->nullable();
            $table->double('nilaiAkhir');
            $table->timestamps();

            $table->foreign('idTugas')->references('id')->on('tugas')->onDelete('cascade');
            $table->foreign('idMahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kinerja');
    }
};
