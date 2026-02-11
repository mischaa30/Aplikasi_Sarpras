<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiItem extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $table = 'inspeksi_items';
    protected $fillable = ['kategori_id', 'nama_item', 'aktif'];

    public function kategori()
    {
        return $this->belongsTo(KategoriSarpras::class, 'kategori_id');
    }

    public function hasil()
    {
        return $this->hasMany(InspeksiItemResult::class, 'inspeksi_item_id');
    }
}
