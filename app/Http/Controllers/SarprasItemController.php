<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SarprasItem;
use App\Models\Sarpras;
use App\Models\KondisiSarpras;

class SarprasItemController extends Controller
{
    public function store(Request $r, Sarpras $sarpras)
    {
        SarprasItem::create([
            'sarpras_id' => $sarpras->id,
            'nama_item' => $r->nama_item,
            'kondisi_sarpras_id' => $r->kondisi_sarpras_id
        ]);

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
        $item->delete();
        return back();
    }
}

