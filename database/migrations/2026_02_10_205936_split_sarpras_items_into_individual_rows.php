<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $items = DB::table('sarpras_item')->where('jumlah', '>', 1)->get();

        foreach ($items as $item) {
            $qty = $item->jumlah;
            // Create (qty - 1) new new records
            for ($i = 0; $i < $qty - 1; $i++) {
                DB::table('sarpras_item')->insert([
                    'sarpras_id' => $item->sarpras_id,
                    'nama_item' => $item->nama_item,
                    'kondisi_sarpras_id' => $item->kondisi_sarpras_id,
                    'jumlah' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Update original record to count as 1
            DB::table('sarpras_item')
                ->where('id', $item->id)
                ->update(['jumlah' => 1]);
        }
    }

    public function down(): void
    {
        // One-way migration
    }
};
