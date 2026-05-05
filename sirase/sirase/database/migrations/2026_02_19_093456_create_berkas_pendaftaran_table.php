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
        Schema::create('berkas_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPendaftaran');
            $table->unsignedBigInteger('idKontenFormulir');
            $table->string('namaFile');
            $table->text('filePath');
            $table->timestamps();

           $table->foreign('idPendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
            $table->foreign('idKontenFormulir')->references('id')->on('konten_formulir')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_pendaftaran');
    }
};
