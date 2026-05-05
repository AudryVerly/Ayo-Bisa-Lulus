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
        Schema::create('penilaian_setiap_bobot', function (Blueprint $table) {
            $table->unsignedBigInteger('idPenilaianKandidat');
            $table->unsignedBigInteger('idBobotKriteria');
            $table->integer('nilaiAwal')->nullable();
            $table->double('nilaiAkhir')->nullable();
            $table->timestamps();

            $table->primary([
                'idPenilaianKandidat',
                'idBobotKriteria',
            ]);

            $table->foreign('idPenilaianKandidat')
                ->references('id')
                ->on('penilaian_kandidat')
                ->onDelete('cascade');

            $table->foreign('idBobotKriteria')
                ->references('id')
                ->on('bobot_kriteria')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_setiap_bobot');
    }
};
