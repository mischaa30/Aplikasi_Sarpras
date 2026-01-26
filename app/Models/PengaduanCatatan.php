<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanCatatan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan_catatans';

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'catatan',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
