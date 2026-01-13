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
            $table->string('kode_sarpras')->unique();
            $table->string('nama_sarpras');
            $table->foreignId('kategori_id')->constrained('kategori_sarpras');
            $table->string('lokasi');
            $table->string('jumlah_stok')->default(0);
            $table->enum('kondisi_saat_ini',['Baik','Rusak Ringan','Rusak Berat','Hilang'])->default('Baik');
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
