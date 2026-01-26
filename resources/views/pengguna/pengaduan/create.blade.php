<h2>Buat Pengaduan</h2>

<form action="{{ route('pengguna.pengaduan.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      style="max-width:500px">

    @csrf

    <div style="margin-bottom:12px">
        <label>Judul Pengaduan</label><br>
        <input type="text" name="judul" 
               placeholder="Contoh: Proyektor Rusak"
               required
               style="width:100%; padding:8px">
    </div>

    <div style="margin-bottom:12px">
        <label>Deskripsi Masalah</label><br>
        <textarea name="deskripsi"
                  placeholder="Jelaskan kerusakan secara detail"
                  required
                  rows="4"
                  style="width:100%; padding:8px"></textarea>
    </div>

    <div style="margin-bottom:12px">
        <label>Lokasi</label><br>
        <select name="lokasi_id" required style="width:100%; padding:8px">
            <option value="">-- Pilih Lokasi --</option>
            @foreach($lokasi as $l)
                <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:12px">
        <label>Jenis Sarpras</label><br>
        <select name="kategori_sarpras_id" required style="width:100%; padding:8px">
            <option value="">-- Pilih Jenis Sarpras --</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:12px">
        <label>Foto (opsional)</label><br>
        <input type="file" name="foto">
    </div>

    <button type="submit"
            style="padding:10px 16px; background:#4f46e5; color:white; border:none; cursor:pointer">
        Kirim Pengaduan
    </button>
</form>
