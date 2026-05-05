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
        Schema::create('penilaian_kandidat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPendaftaran');
            $table->unsignedBigInteger('idWawancaraPenilai');
            $table->double('nilaiFinal');
            $table->text('catatan');
            $table->date('tanggal_menilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kandidat');
    }
};
