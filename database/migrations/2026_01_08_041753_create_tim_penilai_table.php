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
        Schema::create('tim_penilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idLowongan');
            $table->unsignedBigInteger('idStaffUnit');
            $table->enum('statusPenilaian',['Belum','Sudah']);
            $table->tinyInteger('isActive')->default(1);
            $table->timestamps();

            $table->foreign('idLowongan')->references('id')->on('lowongan')->onDelete('cascade');
            $table->foreign('idStaffUnit')->references('id')->on('staffunit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_penilai');
    }
};
