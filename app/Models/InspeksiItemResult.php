<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiItemResult extends Model
{
    use \App\Traits\LogsActivity;

    protected $table = 'inspeksi_item_results';
    protected $fillable = [
        'inspeksi_id',
        'inspeksi_item_id',
        'kondisi_sarpras_id',
        'catatan'
    ];

    public function inspeksi()
    {
        return $this->belongsTo(Inspeksi::class);
    }

    public function item()
    {
        return $this->belongsTo(InspeksiItem::class, 'inspeksi_item_id');
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_sarpras_id');
    }
}
