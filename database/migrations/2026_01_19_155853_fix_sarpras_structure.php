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
        Schema::table('sarpras', function (Blueprint $table) {

            //LEPAS FOREIGN KEY DULU
            if (Schema::hasColumn('sarpras', 'id_kondisi_sarpras')) {
                $table->dropForeign('sarpras_id_kondisi_sarpras_foreign');
                $table->dropColumn('id_kondisi_sarpras');
            }

            //HAPUS KOLOM STOK LAMA JIKA ADA
            if (Schema::hasColumn('sarpras', 'jumlah_stok')) {
                $table->dropColumn('jumlah_stok');
            }
        });
    }

    public function down(): void
    {
        //
    }

};
