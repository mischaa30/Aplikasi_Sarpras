<?php

namespace App\Models;
use App\Models\User;
use App\Models\Sarpras;
use App\Models\SarprasItem;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'sarpras_id',
        'sarpras_item_id',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali_actual',
        'tujuan',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo(SarprasItem::class, 'sarpras_item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class, 'sarpras_id');
    }
    public function detail()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }
}
