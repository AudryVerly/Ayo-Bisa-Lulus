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
        Schema::create('konten_formulir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idLowongan');
            $table->string('namaField');
            $table->enum('tipeField',['text','number','date','textarea','select','radio','checkbox','file','phone']);
            $table->string('opsi_field')->nullable();
            $table->tinyInteger('required')->default(0);
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
        Schema::dropIfExists('konten_formulir');
    }
};
