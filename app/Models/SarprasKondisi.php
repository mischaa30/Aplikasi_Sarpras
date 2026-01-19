<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SarprasKondisi extends Model
{
    protected $table = 'sarpras_kondisi';

    protected $fillable = [
        'sarpras_id',
        'kondisi_sarpras_id',
        'jumlah'
    ];

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class, 'kondisi_sarpras_id');
    }

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class,'sarpras_id');
    }
}
