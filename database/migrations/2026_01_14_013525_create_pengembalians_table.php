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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')
            ->unique()
            ->constrained('peminjaman')
            ->onDelete('cascade');
            $table->foreignId('id_kondisi_sarpras')->constrained('kondisi_sarpras');
            $table->date('tgl_pengembalian');
            $table->text('deskripsi_kerusakan')->nullable();
            $table->string('foto_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
