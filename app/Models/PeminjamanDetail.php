<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    protected $table = 'peminjaman_detail';
    protected $fillable = ['peminjaman_id','sarpras_id','jumlah'];

    public function sarpras(){
        return $this->belongsTo(Sarpras::class);
    }
    public function kondisi(){
        return $this->belongsTo(KondisiSarpras::class,'kondisi_sarpras_id');
    }
}
