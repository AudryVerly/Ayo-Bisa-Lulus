<?php

use App\Models\PenjadwalanWawancara;
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
        Schema::create('tim_penilai_wawancara', function (Blueprint $table) {
            $table->foreignId('idJadwalWawancara')->constrained('jadwal_wawancara') ->cascadeOnDelete();
            $table->foreignId('idTimPenilai') ->constrained('tim_penilai') ->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['idJadwalWawancara','idTimPenilai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_penilai_wawancara');
    }

};
