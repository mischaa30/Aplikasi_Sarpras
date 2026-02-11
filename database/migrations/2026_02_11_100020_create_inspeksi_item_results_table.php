<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inspeksi_item_results')) {
            Schema::create('inspeksi_item_results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('inspeksi_id')->constrained('inspeksis')->cascadeOnDelete();
                $table->foreignId('inspeksi_item_id')->constrained('inspeksi_items')->cascadeOnDelete();
                $table->foreignId('kondisi_sarpras_id')->constrained('kondisi_sarpras')->restrictOnDelete();
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_item_results');
    }
};
