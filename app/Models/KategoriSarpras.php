<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriSarpras extends Model
{
    use HasFactory;
    use SoftDeletes;
    // menentukan tabel
    protected $table = 'kategori_sarpras';

    //field yang boleh diisi lewat form
    protected $fillable = ['nama_kategori','parent_id'];

    public function parent()
    {
        return $this->belongsTo(KategoriSarpras::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(KategoriSarpras::class,'parent_id');
    }
}
