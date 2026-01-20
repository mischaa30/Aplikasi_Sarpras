<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'role_users';
    protected $fillable = ['nama_role'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
    use HasFactory;
}
