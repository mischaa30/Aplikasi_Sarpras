<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSarpras extends Model
{
    // menentukan tabel
    protected $table = 'kategori_sarpras';

    //field yang boleh diisi lewat form
    protected $fillable = ['nama_kategori'];

    //use HasFactory;
}
