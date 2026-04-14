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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idStaffUnit');
            $table->unsignedBigInteger('idUnit');
            $table->string('namaTugas');
            $table->text('deskripsi');
            $table->double('bobotNilai');
            $table->date('tenggatPengumpulan');
            $table->enum('progressTugas',['assigned','inProgress','revisi','done']);
            $table->timestamps();

            $table->foreign('idStaffUnit')->references('id')->on('staffunit')->onDelete();
            $table->foreign('idUnit')->references('id')->on('unit')->onDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
