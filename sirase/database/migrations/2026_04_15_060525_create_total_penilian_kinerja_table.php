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
        Schema::create('total_penilian_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPendaftaran');
            $table->double('totalNilai');
            $table->string('kategori');
            $table->timestamps();

            $table->foreign('idPendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_penilian_kinerja');
    }
};
