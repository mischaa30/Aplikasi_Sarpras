<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sarpras extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'kode_sarpras',
        'nama_sarpras',
        'kategori_id',
        'id_lokasi'
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class,'id_lokasi');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarpras::class);
    }

    public function items()
    {
        return $this->hasMany(SarprasItem::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_id');
    }
}
