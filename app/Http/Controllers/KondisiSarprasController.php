<?php

namespace App\Http\Controllers;

use App\Models\KondisiSarpras;
use Illuminate\Http\Request;

class KondisiSarprasController extends Controller
{
    public function index()
    {
        $kondisi = KondisiSarpras::withTrashed()->get();
        return view('admin.kondisi.index', compact('kondisi'));
    }

    public function create()
    {
        return view('admin.kondisi.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_kondisi' => 'required|unique:kondisi_sarpras,nama_kondisi'
        ]);

        KondisiSarpras::create([
            'nama_kondisi' => $r->nama_kondisi
        ]);

        return redirect()->route('admin.kondisi.index');
    }

    public function destroy(KondisiSarpras $kondisiSarpras)
    {
        $kondisiSarpras->delete();
        return redirect()->back();
    }

    public function restore($id)
    {
        KondisiSarpras::withTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
