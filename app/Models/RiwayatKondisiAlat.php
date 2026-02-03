<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SarprasItem;

class RiwayatKondisiAlat extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kondisi_alat';

    protected $fillable = [
        'peminjaman_id',
        'peminjaman_detail_id',
        'sarpras_id',
        'kondisi_sarpras_id',
        'deskripsi',
        'foto',
        'sarpras_item_id'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_sarpras_id');
    }

    public function item()
    {
        return $this->belongsTo(SarprasItem::class, 'sarpras_item_id');
    }
}
