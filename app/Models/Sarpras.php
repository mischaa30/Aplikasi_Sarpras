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
        'id_lokasi',
        'kategori_id'
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class,'id_lokasi');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarpras::class,'kategori_id');
    }

    public function kondisiDetail()
    {
        return $this->hasMany(SarprasKondisi::class);
    }
}
