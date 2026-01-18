<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    protected $table = 'sarpras';
    protected $fillable = [
        'id_lokasi',
        'id_kondisi_sarpras',
        'kode_sarpras',
        'nama_sarpras',
        'kategori_id',
        'jumlah_stok'
    ];

    //RELASI
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class,'id_kondisi_sarpras');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarpras::class,'kategori_id');
    }
}
