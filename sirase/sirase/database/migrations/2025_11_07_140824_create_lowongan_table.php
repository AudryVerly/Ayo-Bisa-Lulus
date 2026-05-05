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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUnit');
            $table->string('judulLowongan');
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->string('posisiLowongan');
            $table->double('durasiKerja');
            $table->date('awalPendaftaran');
            $table->date('batasPendaftaran');
            $table->date('mulaiKerja');
            $table->date('akhirKerja');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('idUnit')->references('id')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
