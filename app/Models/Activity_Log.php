<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity_Log extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'ip', // Keep 'ip' for backward compat if any code uses it, but prefer 'ip_address'
        'ip_address',
        'user_agent',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
