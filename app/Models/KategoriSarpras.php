<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriSarpras extends Model
{
    use SoftDeletes;
    // menentukan tabel
    protected $table = 'kategori_sarpras';

    //field yang boleh diisi lewat form
    protected $fillable = ['nama_kategori'];

    //use HasFactory;
}
