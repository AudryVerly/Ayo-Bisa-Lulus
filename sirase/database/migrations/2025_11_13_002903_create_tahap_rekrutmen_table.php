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
        Schema::create('tahap_rekrutmen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idLowongan');
            $table->string('name');
            $table->integer('urutan');
            $table->enum('tipe_tahap',['Seleksi','Wawancara','Final']);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('idLowongan')->references('id')->on('lowongan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap_rekrutmen');
    }
};
