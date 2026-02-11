<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inspeksi_items')) {
            Schema::create('inspeksi_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kategori_id')->constrained('kategori_sarpras')->cascadeOnDelete();
                $table->string('nama_item');
                $table->boolean('aktif')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_items');
    }
};
