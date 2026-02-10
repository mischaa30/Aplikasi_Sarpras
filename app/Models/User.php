<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'id_role'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
