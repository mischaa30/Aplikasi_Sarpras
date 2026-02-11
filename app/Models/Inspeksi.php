<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    use \App\Traits\LogsActivity;

    protected $table = 'inspeksis';
    protected $fillable = ['peminjaman_id', 'tipe', 'checked_by', 'checked_at'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function hasil()
    {
        return $this->hasMany(InspeksiItemResult::class, 'inspeksi_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
