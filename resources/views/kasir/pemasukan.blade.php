<div class="card p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h5>Pemasukan Hari Ini: Rp {{ number_format($saldoHariIni,0,',','.') }}</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPemasukan">
            +
        </button>
    </div>
</div>

<!-- Daftar Pemasukan -->
<table class="table">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Item</th>
            <th>Jumlah</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemasukan as $p)
        <tr>
            <td>{{ $p->kategori }}</td>
            <td>{{ $p->item }}</td>
            <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
            <td>{{ $p->created_at->format('H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah Pemasukan -->
<div class="modal fade" id="tambahPemasukan" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('pemasukan.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <select name="kategori" class="form-select mb-2" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Mobil">Mobil</option>
                     <option value="Mobil">Motor</option>
                      <option value="Mobil">Karpet</option>
                    <option value="Produk Tambahan">Produk Tambahan</option>
                    <option value="Minuman">Minuman</option>
                </select>
                <input type="text" name="item" class="form-control mb-2" placeholder="Nama Item">
                <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Rp" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>
