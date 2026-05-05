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
        Schema::create('kriteria_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idKriteria');
            $table->unsignedBigInteger('idUnit');
            $table->string('nama');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('idKriteria')->references('id')->on('kriteria')->onDelete('cascade');
            $table->foreign('idUnit')->references('id')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_kinerja');
    }
};
