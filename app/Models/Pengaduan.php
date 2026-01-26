<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'status_pengaduan_id',
        'kategori_sarpras_id',
        'lokasi_id',
        'judul',
        'deskripsi',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status_Pengaduan::class, 'status_pengaduan_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarpras::class, 'kategori_sarpras_id');
    }

    public function catatan()
    {
        return $this->hasMany(PengaduanCatatan::class, 'pengaduan_id');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
