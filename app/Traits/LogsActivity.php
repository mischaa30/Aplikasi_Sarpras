<?php

namespace App\Traits;

use App\Models\Activity_Log;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('Created', $model);
        });

        static::updated(function ($model) {
            self::logActivity('Updated', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('Deleted', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        if (!Auth::check()) return;

        $user = Auth::user();
        $modelName = class_basename($model);
        $description = "$action $modelName";

        // Try to find a name or title
        if ($model->nama_item) {
            $description .= ": " . $model->nama_item;
        } elseif ($model->nama_sarpras) {
            $description .= ": " . $model->nama_sarpras;
        } elseif ($model->username) {
            $description .= ": " . $model->username;
        } elseif ($model->judul) { // Pengaduan
            $description .= ": " . $model->judul;
        }

        // METADATA
        $metaData = [];
        if ($action === 'Created') {
            $metaData = [
                'new' => $model->getAttributes()
            ];
        } elseif ($action === 'Updated') {
            $original = $model->getOriginal();
            $changes = $model->getChanges();
            
            // Filter changes to show Old vs New
            $metaChanges = [];
            foreach ($changes as $key => $value) {
                if ($key === 'updated_at') continue;
                $metaChanges[$key] = [
                    'old' => $original[$key] ?? null,
                    'new' => $value
                ];
            }
            $metaData = ['changes' => $metaChanges];
        } elseif ($action === 'Deleted') {
            $metaData = [
                'old' => $model->getAttributes()
            ];
        }

        Activity_Log::create([
            'user_id' => $user->id,
            'aksi' => $action,
            'deskripsi' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta_data' => $metaData
        ]);
    }
}
