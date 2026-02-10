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
        'ip',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
