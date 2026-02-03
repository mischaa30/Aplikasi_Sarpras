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
        Schema::table('riwayat_kondisi_alat', function (Blueprint $table) {
            $table->foreignId('sarpras_item_id')
                ->nullable()
                ->constrained('sarpras_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_kondisi_alat', function (Blueprint $table) {
            //
        });
    }
};
