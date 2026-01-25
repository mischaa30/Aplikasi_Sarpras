<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use Illuminate\Http\Request;

class PenggunaSarprasController extends Controller
{
    public function index(Request $r)
    {
        $search = $r->search;

        $sarpras = Sarpras::with(['kategori', 'items' => function ($q) {
                $q->where('jumlah', '>', 0);
            }])
            ->when($search, function ($q) use ($search) {
                $q->where('nama_sarpras', 'like', "%$search%")
                  ->orWhereHas('items', function ($i) use ($search) {
                      $i->where('nama_item', 'like', "%$search%");
                  });
            })
            ->get();

        return view('pengguna.sarpras.index', compact('sarpras'));
    }
}
