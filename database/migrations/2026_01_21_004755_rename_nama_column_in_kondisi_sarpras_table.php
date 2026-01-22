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
        Schema::table('kondisi_sarpras', function (Blueprint $table) {
            $table->renameColumn('nama_sarpras','nama_kondisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kondisi_sarpras', function (Blueprint $table) {
            $table->renameColumn('nama_kondisi','nama_sarpras');
        });
    }
};
