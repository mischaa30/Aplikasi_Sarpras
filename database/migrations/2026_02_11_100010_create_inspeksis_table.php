<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inspeksis')) {
            Schema::create('inspeksis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();
                $table->enum('tipe', ['Sebelum', 'Sesudah']);
                $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('checked_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksis');
    }
};
