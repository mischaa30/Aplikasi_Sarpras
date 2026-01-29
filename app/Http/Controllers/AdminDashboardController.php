<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Sarpras;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUser' => User::count(),
            'totalSarpras' => Sarpras::count(),
            'totalPeminjaman' => Peminjaman::count(),
        ]);
    }
}
