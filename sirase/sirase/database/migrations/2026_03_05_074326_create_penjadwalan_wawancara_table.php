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
        Schema::create('jadwal_wawancara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProgressTahapan');
            $table->unsignedBigInteger('idPendaftaran');
            $table->date('tanggal_wawancara');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('lokasi');
            $table->text('link_wawancara');
            $table->text('keterangan');
            $table->enum('status',['terjadwal','selesai','batal']);
            $table->timestamps();

            $table->foreign('idProgressTahapan')->references('id')->on('progress_tahapan_kandidat')->onDelete('cascade');
            $table->foreign('idPendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjadwalan_wawancara');
    }
};
