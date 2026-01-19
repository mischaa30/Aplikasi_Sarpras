<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use App\Models\SarprasKondisi;
use App\Models\KondisiSarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SarprasKondisiController extends Controller
{
    public function create(Sarpras $sarpras)
    {
        $listKondisi = KondisiSarpras::all();

        return view('admin.sarpras.kondisi_create', compact(
            'sarpras',
            'listKondisi'
        ));
    }

    public function store(Request $r, Sarpras $sarpras)
    {
        $r->validate([
            'kondisi_sarpras_id' => 'required',
            'jumlah' => 'required|numeric|min:1'
        ]);

        SarprasKondisi::updateOrCreate(
            [
                'sarpras_id' => $sarpras->id,
                'kondisi_sarpras_id' => $r->kondisi_sarpras_id
            ],
            [
                'jumlah' => DB::raw('jumlah + '.$r->jumlah)
            ]
        );

        return back()->with('success','Stok berhasil ditambahkan');
    }
}
