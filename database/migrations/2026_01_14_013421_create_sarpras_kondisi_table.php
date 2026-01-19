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
        Schema::create('sarpras_kondisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarpras_id')->constrained('sarpras');
            $table->foreignId('kondisi_sarpras_id')->constrained('kondisi_sarpras');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarpras_kondisi');
    }
};
