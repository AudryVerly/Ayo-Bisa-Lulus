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
        Schema::create('tugas_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('idMahasiswa');
            $table->unsignedBigInteger('idTugas');
            $table->enum('statusPengumpulan', ['terlambat', 'tepatwaktu']);
            $table->date('tanggalPengumpulan');
            $table->text('file_path');
            $table->timestamps();

            $table->primary([
                'idMahasiswa',
                'idTugas',
            ]);

            $table->foreign('idMahasiswa')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
            $table->foreign('idTugas')
                ->references('id')
                ->on('tugas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_mahasiswa');
    }
};
