<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SarprasItem;
use App\Models\Sarpras;
use App\Models\KondisiSarpras;

class SarprasItemController extends Controller
{
    public function userIndex(Sarpras $sarpras)
    {
        $items = SarprasItem::with('kondisi')
            ->where('sarpras_id', $sarpras->id)
            ->get();

        return view('pengguna.item.index', compact('sarpras', 'items'));
    }
    public function create(Sarpras $sarpras)
    {
        return view('admin.sarpras.item_create', [
            'sarpras' => $sarpras,
            'listKondisi' => KondisiSarpras::all()
        ]);
    }

    public function store(Request $r, Sarpras $sarpras)
    {
        $r->validate([
            'nama_item' => 'required',
            'kondisi_sarpras_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $jumlah = (int) $r->jumlah;

        for ($i = 0; $i < $jumlah; $i++) {
            SarprasItem::create([
                'sarpras_id' => $sarpras->id,
                'nama_item' => $r->nama_item,
                'kondisi_sarpras_id' => $r->kondisi_sarpras_id,
                'jumlah' => 1 // Always 1 per record
            ]);
        }

        $sarpras->increment('stok', $jumlah);

        return back();
    }

    public function edit(SarprasItem $item)
    {
        return view('admin.sarpras.item_edit', [
            'item' => $item,
            'listKondisi' => KondisiSarpras::all()
        ]);
    }

    public function update(Request $r, SarprasItem $item)
    {
        $item->update($r->all());
        return redirect()->route('admin.sarpras.show', $item->sarpras_id);
    }

    public function destroy(SarprasItem $item)
    {
        $sarpras = $item->sarpras;
        $jumlah = $item->jumlah ?? 1; // Default to 1 if null
        $item->delete();
        $sarpras->decrement('stok', $jumlah);
        return back();
    }
}

