<form action="{{ route('pengeluaran.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label for="karyawan">Karyawan</label>
        <select name="karyawan_id" id="karyawan" class="form-select" required>
            @foreach($karyawan as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
    </div>
    <div class="mb-2">
        <label for="nominal">Nominal</label>
        <input type="number" name="nominal" id="nominal" class="form-control" required>
    </div>
    <div class="mb-2">
        <label for="deskripsi">Deskripsi</label>
        <input type="text" name="deskripsi" id="deskripsi" class="form-control">
    </div>
    <input type="hidden" name="jenis" value="kasbon">
    <button type="submit" class="btn btn-primary">Simpan Kasbon</button>
</form>
