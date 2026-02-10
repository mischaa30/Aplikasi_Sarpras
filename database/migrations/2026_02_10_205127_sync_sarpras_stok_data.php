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
        // Update stok based on sum of quantity in sarpras_item
        DB::statement("
            UPDATE sarpras s
            SET stok = (
                SELECT COALESCE(SUM(jumlah), 0)
                FROM sarpras_item si
                WHERE si.sarpras_id = s.id
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse data sync
    }
};
