<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $table = 'lokasis';

    protected $fillable = [
        'nama_lokasi'
    ];

    // relasi ke sarpras
    public function sarpras()
    {
        return $this->hasMany(Sarpras::class, 'id_lokasi');
    }
}
