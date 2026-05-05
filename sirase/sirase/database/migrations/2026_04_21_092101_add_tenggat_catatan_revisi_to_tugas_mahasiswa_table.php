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
        Schema::table('tugas_mahasiswa', function (Blueprint $table) {
            $table->date('tenggatRevisi')->nullable()->after('tanggalPengumpulan');
            $table->text('catatanRevisi')->nullable()->after('tenggatRevisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('tenggatRevisi');
            $table->dropColumn('catatanRevisi');
        });
    }
};
