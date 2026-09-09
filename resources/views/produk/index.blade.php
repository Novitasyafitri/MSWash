<x-app-layout :title="$activeKategori === 'layanan' ? 'Data Layanan' : 'Data Stok'">

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* CARD */
.card-modern {
    border-radius: 30px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    padding: 18px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}

thead {
    background: #5ca8ff;
    color: white;
}

th, td {
    padding: 12px 14px;
    font-size: 14px;
}

tbody tr:hover td {
     background: #e5e7eb;   /* abu-abu halus */
    cursor: pointer;
}

/* AKSI */
.td-aksi {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 70%;
    border: none;
    background: #eef1f6;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
}
.btn-action:hover {
    background: #e5e7eb;
}

.btn-edit { color: #2563eb; }
.btn-delete { color: #e11d48; }

.filter-group {
    display: flex;
    gap: 8px;
}
.page-title {
    font-size: 24px;
    font-weight: 600;   /* INI YANG BIKIN TEBAL */
    color: #111827;
    margin-bottom: 16px;
    letter-spacing: 0.2px;
}
/* FILTER BUTTON BULAT */
.filter-group .btn {
    border-radius: 999px !important;
    padding: 8px 18px;
    font-weight: 600;
}
.table-responsive {
    width: 100%;
    overflow-x: auto;
}

/* Responsive untuk HP */
@media (max-width: 480px) {
    th, td {
        padding: 12px 16px;
        font-size: 14px;
        white-space: nowrap;
    }

    .btn-action {
        width: 28px;
        height: 28px;
    }

    .page-title {
        font-size: 18px;
    }
}
/* Judul turun sedikit biar tidak ketutup hamburger */
@media (max-width: 640px) {
    .page-title {
        margin-top: 40px !important;
    }
}
/* ===================== KHUSUS HALAMAN STOK ===================== */
.mode-stok table th,
.mode-stok table td {
    min-width: 110px; /* kolom tidak terlalu sempit */
}

/* Kolom Nama */
.mode-stok table th:nth-child(2),
.mode-stok table td:nth-child(2) {
    min-width: 150px;
}

/* Kolom Kategori */
.mode-stok table th:nth-child(3),
.mode-stok table td:nth-child(3) {
    min-width: 130px;
}

/* Jika ada kolom Harga (sub = minuman) */
.mode-stok table th:nth-child(4),
.mode-stok table td:nth-child(4) {
    min-width: 120px;
}

/* Responsive HP */
@media (max-width: 480px) {

    .mode-stok table th,
    .mode-stok table td {
        min-width: 95px !important;
    }

    .mode-stok table th:nth-child(2),
    .mode-stok table td:nth-child(2) {
        min-width: 140px !important; /* Nama */
    }
}
</style>

<div class="container pt-3 {{ $activeKategori === 'stok' ? 'mode-stok' : '' }}">

<h4 class="page-title">
    {{ $activeKategori === 'layanan' ? 'Data Layanan' : 'Data Stok' }}
</h4>


{{-- TAMBAH LAYANAN --}}
@if(Auth::user()->role === 'pemilik' && $activeKategori === 'layanan')
    <a href="{{ route('produk.create', ['kategori'=>'layanan']) }}"
       class="btn btn-primary mb-3">
        + Tambah Layanan
    </a>
@endif

{{-- FILTER STOK --}}
@if($activeKategori === 'stok')
<div class="mb-3 filter-group">
    <a href="{{ route('produk.index',['kategori'=>'stok','sub'=>'stok_barang']) }}"
       class="btn {{ $sub === 'stok_barang' ? 'btn-primary' : 'btn-secondary' }}">
        Stok Barang
    </a>

    <a href="{{ route('produk.index',['kategori'=>'stok','sub'=>'minuman']) }}"
       class="btn {{ $sub === 'minuman' ? 'btn-primary' : 'btn-secondary' }}">
        Minuman
    </a>
</div>
@endif

<div class="card-modern">
     <div class="table-responsive">
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>

            @if($activeKategori === 'layanan')
                <th>Harga</th>
                @if(Auth::user()->role === 'pemilik')
                    <th class="text-center">Aksi</th>
                @endif
            @else
                <th>Kategori</th>
                @if($sub === 'minuman')
                    <th>Harga</th>
                @endif
                <th>Stok</th>
                @if(Auth::user()->role === 'pemilik')
                    <th class="text-center">Aksi</th>
                @endif
            @endif
        </tr>
    </thead>

    <tbody>
    @forelse($produk as $i => $p)
        <tr id="row-{{ $p->id }}">
             <td>{{ $loop->iteration }}</td> 
            <td>{{ $p->nama }}</td>

            {{-- LAYANAN --}}
            @if($activeKategori === 'layanan')
                <td>Rp {{ number_format($p->harga,0,',','.') }}</td>

                @if(Auth::user()->role === 'pemilik')
                <td class="td-aksi">
                    <td class="td-aksi">
    <a href="{{ route('produk.edit',$p->id) }}" class="btn-action btn-edit" aria-label="Edit Layanan {{ $p->nama }}">
        <i class="bi bi-pencil-square"></i>
    </a>

    <button type="button" class="btn-action btn-delete btn-hapus" data-id="{{ $p->id }}" aria-label="Hapus Layanan {{ $p->nama }}">
        <i class="bi bi-trash"></i>
    </button>
</td>
                </td>
                @endif

            {{-- STOK --}}
            @else
                <td>{{ ucfirst(str_replace('_',' ',$p->kategori)) }}</td>

                @if($sub === 'minuman')
                    <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                @endif

                <td>{{ $p->stok }}</td>

                @if(Auth::user()->role === 'pemilik')
                <td class="td-aksi">
    @if(strtolower($p->kategori)==='minuman')
        <a href="{{ route('produk.edit',$p->id) }}" class="btn-action btn-edit" aria-label="Edit Stok {{ $p->nama }}">
            <i class="bi bi-pencil-square"></i>
        </a>
    @endif

    <button type="button" class="btn-action btn-delete btn-hapus" data-id="{{ $p->id }}" aria-label="Hapus Stok {{ $p->nama }}">
        <i class="bi bi-trash"></i>
    </button>
</td>
                @endif
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                Belum ada data
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>
</div>
</div>

<script>
function toast(msg, color = "#2563eb") {
    Toastify({
        text: msg,
        duration: 2500,
        gravity: "top",
        position: "right",
        style: {
            background: color,
            borderRadius: "12px",
            padding: "14px 22px",
            fontSize: "14px",
            fontWeight: "500"
        }
    }).showToast();
}

document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;

        // === POPUP SEDERHANA ===
        if (!confirm("Yakin hapus data ini?")) return;

        fetch(`/produk/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        }).then(() => {
            document.getElementById(`row-${id}`)?.remove();
            toast("Data berhasil dihapus", "#ef4444");
        });
    });
});
</script>
@if(session('success'))
<script>
    toast(@json(session('success')), "#0d6efd");
</script>
@endif
</x-app-layout>
