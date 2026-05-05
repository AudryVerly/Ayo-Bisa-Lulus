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
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            $table->tinyInteger('is_active')->after('nilaiBobot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bobot_kriteria', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
