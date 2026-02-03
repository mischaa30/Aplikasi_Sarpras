<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    protected $table = 'peminjaman_detail';
    protected $fillable = ['peminjaman_id','sarpras_id','sarpras_item_id'];

    public function sarpras(){
        return $this->belongsTo(Sarpras::class);
    }
    public function item()
    {
        return $this->belongsTo(SarprasItem::class, 'sarpras_item_id');
    }
    public function sarprasItem()
    {
        return $this->belongsTo(SarprasItem::class, 'sarpras_item_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
