<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KondisiSarpras extends Model
{
    use SoftDeletes;
    protected $table = 'kondisi_sarpras';
}