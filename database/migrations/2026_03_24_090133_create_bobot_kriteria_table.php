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
        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUnit');
            $table->unsignedBigInteger('idKriteria');
            $table->double('nilaiBobot');
            $table->timestamps();

            $table->foreign('idUnit')->references('id')->on('unit')->onDelete('cascade');
            $table->foreign('idKriteria')->references('id')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_kriteria');
    }
};
