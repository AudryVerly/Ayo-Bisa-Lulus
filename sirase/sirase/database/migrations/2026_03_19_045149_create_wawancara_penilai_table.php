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
        Schema::create('wawancara_penilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idJadwalWawancara');
            $table->unsignedBigInteger('idStaffUnit');
            $table->enum('status',['sudah','belum','terjadwal'])->default('belum');
            $table->timestamps();

            $table->foreign('idJadwalWawancara')->references('id')->on('jadwal_wawancara')->onDelete('cascade');
            $table->foreign('idStaffUnit')->references('id')->on('staffUnit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wawancara_penilai');
    }
};
