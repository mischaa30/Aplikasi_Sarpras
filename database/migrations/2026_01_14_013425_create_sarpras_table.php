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
        Schema::create('sarpras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lokasi')->constrained('lokasis');
            $table->foreignId('id_kondisi_sarpras')->constrained('kondisi_sarpras');
            $table->string('kode_sarpras')->unique();
            $table->string('nama_sarpras');
            $table->foreignId('kategori_id')->constrained('kategori_sarpras');
            $table->integer('jumlah_stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarpras');
    }
};
