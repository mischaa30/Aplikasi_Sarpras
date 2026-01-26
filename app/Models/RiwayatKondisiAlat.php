<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'foto'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function detail()
    {
        return $this->belongsTo(PeminjamanDetail::class, 'peminjaman_detail_id');
    }

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_sarpras_id');
    }
}
