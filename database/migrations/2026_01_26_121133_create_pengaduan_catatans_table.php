<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_catatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')
                  ->constrained('pengaduans');
            // admin / petugas yang memberi catatan
            $table->foreignId('user_id')
                  ->constrained('users');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_catatans');
    }
};
