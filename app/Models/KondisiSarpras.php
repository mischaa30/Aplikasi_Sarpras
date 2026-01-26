<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KondisiSarpras extends Model
{
    use SoftDeletes;
    protected $table = 'kondisi_sarpras';

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_sarpras_id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatKondisiAlat::class,'kondisi_sarpras_id');
    }
}