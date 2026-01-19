<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $fillable = ['username', 'password', 'id_role'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    //use HasFactory;
}
