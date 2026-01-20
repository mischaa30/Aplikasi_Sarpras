<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SarprasItem extends Model
{
    protected $table = 'sarpras_item';
    protected $fillable = [
        'sarpras_id',
        'nama_item',
        'kondisi_sarpras_id'
    ];

    public function kondisi()
    {
        return $this->belongsTo(KondisiSarpras::class,'kondisi_sarpras_id');
    }
}
