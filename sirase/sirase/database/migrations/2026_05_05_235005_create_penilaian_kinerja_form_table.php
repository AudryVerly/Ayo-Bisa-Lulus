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
        Schema::create('penilaian_kinerja_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idMahasiswa');
            $table->unsignedBigInteger('idKriteriaKinerja');
            $table->unsignedBigInteger('idLowongan');
            $table->unsignedBigInteger('idStaffUnit');
            $table->integer('nilai');
            $table->timestamps();

            $table->foreign('idMahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('idKriteriaKinerja')->references('id')->on('kriteria_kinerja')->onDelete('cascade');
            $table->foreign('idLowongan')->references('id')->on('lowongan')->onDelete('cascade');
            $table->foreign('idStaffUnit')->references('id')->on('staffunit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kinerja_form');
    }
};
