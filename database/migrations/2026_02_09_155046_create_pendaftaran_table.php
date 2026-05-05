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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idMahasiswa');
            $table->unsignedBigInteger('idLowongan');
            $table->dateTime('tanggal_daftar');
            $table->enum('statusPendaftaran',['terdaftar','diproses','diterima','ditolak']);
            $table->timestamps();

            $table->foreign('idMahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('idLowongan')->references('id')->on('lowongan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
