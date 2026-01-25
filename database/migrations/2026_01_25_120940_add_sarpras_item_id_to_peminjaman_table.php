<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->foreignId('sarpras_item_id')
                ->nullable()
                ->after('sarpras_id')
                ->constrained('sarpras_item');
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['sarpras_item_id']);
            $table->dropColumn('sarpras_item_id');
        });
    }
};
