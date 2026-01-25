<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SarprasItem extends Model
{
    protected $table = 'sarpras_item';

    protected $fillable = [
        'sarpras_id',
        'nama_item',
        'kondisi_sarpras_id',
        'jumlah'
    ];

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class,'kondisi_sarpras_id');
    }

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class);
    }

    //FIX STATUS (AMBIL DARI PEMINJAMAN)
    public function peminjamanAktif()
    {
        return $this->hasOne(Peminjaman::class, 'sarpras_item_id')
            ->whereIn('status', ['Menunggu', 'Disetujui']);
    }
}
