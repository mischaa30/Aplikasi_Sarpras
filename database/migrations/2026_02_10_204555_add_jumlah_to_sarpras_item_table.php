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
        if (!Schema::hasColumn('sarpras_item', 'jumlah')) {
            Schema::table('sarpras_item', function (Blueprint $table) {
                $table->integer('jumlah')->default(1)->after('nama_item');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sarpras_item', 'jumlah')) {
            Schema::table('sarpras_item', function (Blueprint $table) {
                $table->dropColumn('jumlah');
            });
        }
    }
};
