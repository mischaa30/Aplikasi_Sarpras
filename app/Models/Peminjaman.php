<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'sarpras_id',
        'sarpras_item_id',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali_actual',
        'tujuan',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo(SarprasItem::class, 'sarpras_item_id');
    }
}
