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
        Schema::table('konten_formulir', function (Blueprint $table) {
            $table->text('help_text')->after('opsi_field');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konten_formulir', function (Blueprint $table) {
            $table->text('help_text')->after('opsi_field');
        });
    }
};
