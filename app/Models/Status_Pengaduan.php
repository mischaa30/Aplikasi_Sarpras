<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_Pengaduan extends Model
{
    use HasFactory;
    
    protected $table = 'status_pengaduans';

    protected $fillable = [
        'nama_status_pengaduan'
    ];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'status_pengaduan_id');
    }
}
