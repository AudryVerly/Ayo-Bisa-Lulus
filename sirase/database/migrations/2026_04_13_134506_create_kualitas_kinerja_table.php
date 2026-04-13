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
        Schema::create('kualitas_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUnit');
            $table->double('nilaiMin');
            $table->double('nilaiMax');
            $table->string('kategori');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

             $table->foreign('idUnit')->references('id')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kualitas_kinerja');
    }
};
