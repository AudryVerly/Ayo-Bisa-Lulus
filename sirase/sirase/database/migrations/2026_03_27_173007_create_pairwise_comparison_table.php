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
        Schema::create('pairwise_comparison', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUnit');
            $table->unsignedBigInteger('kriteriaAwal');
            $table->unsignedBigInteger('kriteriaPembanding');
            $table->double('nilai');
            $table->timestamps();

            $table->foreign('idUnit')->references('id')->on('unit')->onDelete('cascade');
            $table->foreign('kriteriaAwal')->references('id')->on('kriteria')->onDelete('cascade');
            $table->foreign('kriteriaPembanding')->references('id')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pairwise_comparison');
    }
};
