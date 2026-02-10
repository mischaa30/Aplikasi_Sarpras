<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity_Log;

class AdminSystemLogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Activity_Log::with('user');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('aksi', 'like', "%{$q}%")
                   ->orWhere('deskripsi', 'like', "%{$q}%")
                   ->orWhere('ip_address', 'like', "%{$q}%")
                   ->orWhereHas('user', function ($qu) use ($q) {
                       $qu->where('username', 'like', "%{$q}%");
                   });
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $logs = $query->latest()->paginate(25);

        return view('admin.system_log.index', compact('logs'));
    }
}
