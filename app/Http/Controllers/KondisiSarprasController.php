<?php

namespace App\Http\Controllers;

use App\Models\KondisiSarpras;
use App\Models\Activity_Log;
use Illuminate\Http\Request;

class KondisiSarprasController extends Controller
{
    public function index()
    {
        $kondisi = KondisiSarpras::whereNull('deleted_at')->get();
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
        $kondisi = KondisiSarpras::withTrashed()->findOrFail($id);
        $kondisi->restore();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'restore_kondisi',
            'deskripsi' => 'Restore kondisi: ' . $kondisi->nama_kondisi,
        ]);

        return redirect()->back()->with('success', 'Kondisi berhasil direstore');
    }

    public function trash(Request $request)
    {
        $kondisi = KondisiSarpras::onlyTrashed()->paginate(25);
        return view('admin.kondisi.trash', compact('kondisi'));
    }

    public function forceDelete($id)
    {
        $k = KondisiSarpras::onlyTrashed()->findOrFail($id);
        $name = $k->nama_kondisi;
        $k->forceDelete();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'force_delete_kondisi',
            'deskripsi' => 'Permanently deleted kondisi: ' . $name,
        ]);

        return redirect()->back()->with('success', 'Kondisi dihapus permanen');
    }

    public function edit(KondisiSarpras $kondisiSarpras)
    {
        $kondisi = $kondisiSarpras;
        return view('admin.kondisi.edit', compact('kondisi'));
    }

    public function update(Request $r, KondisiSarpras $kondisiSarpras)
    {
        $r->validate([
            'nama_kondisi' => 'required|unique:kondisi_sarpras,nama_kondisi,' . $kondisiSarpras->id
        ]);

        $kondisiSarpras->update([
            'nama_kondisi' => $r->nama_kondisi
        ]);

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil diupdate');
    }
}
