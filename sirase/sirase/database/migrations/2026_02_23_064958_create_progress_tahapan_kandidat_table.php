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
        Schema::create('progress_tahapan_kandidat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTahapRekrutmen');
            $table->unsignedBigInteger('idPendaftaran');
            $table->enum('status',['Proses','Gagal','Lulus']);
            $table->string('catatan');
            $table->timestamps();

            $table->foreign('idTahapRekrutmen')->references('id')->on('tahap_rekrutmen')->onDelete('cascade');
            $table->foreign('idPendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_tahapan_kandidat');
    }
};
