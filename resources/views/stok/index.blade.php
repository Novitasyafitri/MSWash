<x-app-layout :title="'Laporan Stok'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body { font-family: 'Poppins', sans-serif !important; }

h4 {
    font-weight: 600;
    font-size: 22px;
    color: #111827;
}

/* FILTER */
.filter-wrapper { position: relative; }

.btn-add-filter {
    background: none;
    border: none;
    color: #2563eb;
    font-weight: 500;
    cursor: pointer;
    padding: 6px 2px;
}

.filter-dropdown {
    position: absolute;
    top: 34px;
    left: 0;
    width: 260px;
    background: #ffffff;
    padding: 14px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    display: none;
    z-index: 20;
}
.filter-dropdown.show { display: block; }

.filter-date-input {
    width: 100%;
    padding: 8px 10px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

.reset-btn {
    margin-top: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #dc2626;
    cursor: pointer;
    display: none;
}

/* TABLE + LOADING */
#tableWrapper { position: relative; }
#tableWrapper.loading {
    opacity: .5;
    pointer-events: none;
}
#loadingIndicator {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 16px;
}

.table-wrapper {
    border-radius: 16px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed; /* 🔥 KUNCI BIAR KOLOM SAMA BESAR */
}

/* KUNCI LEBAR KOLOM */
.table-modern th:nth-child(1),
.table-modern td:nth-child(1) {
    width: 45%;
}

.table-modern th:nth-child(2),
.table-modern td:nth-child(2) {
    width: 35%;
}

.table-modern th:nth-child(3),
.table-modern td:nth-child(3) {
    width: 20%;
    text-align: center;
}

.table-modern thead th {
    background: #5ca8ff;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 16px;
    text-align: left;
}

.table-modern td {
    padding: 14px 16px;
    font-size: 14px;
    border-bottom: 1px solid #e5e7eb;
}

.table-modern tbody tr:hover td {
    background: #e5e7eb;   /* abu-abu halus */
    cursor: pointer;
}

.text-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #059669;
}
/* KUNCI ALIGNMENT PER KOLOM */
.table-modern th:nth-child(1),
.table-modern td:nth-child(1) {
    text-align: left;
}

.table-modern th:nth-child(2),
.table-modern td:nth-child(2) {
    text-align: left;
}

.table-modern th:nth-child(3),
.table-modern td:nth-child(3) {
    text-align: center;
}
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* scroll halus di iOS */
}
@media (max-width: 640px) {
    h4 {
        margin-top: 40px !important;
    }

    .table-modern th,
    .table-modern td {
        min-width: 120px;
        white-space: nowrap;
    }
}

</style>

<div class="container pt-3">

<h4 class="mb-3">Laporan Stok</h4>

{{-- FILTER BAR --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <div class="filter-wrapper">
        <button class="btn-add-filter" id="btnFilter">
            <i class="bi bi-funnel"></i> Add Filter
        </button>

        <div class="filter-dropdown" id="filterDropdown">
            <form method="GET">
                <select name="kategori"
                        class="filter-date-input"
                        onchange="applyFilter(this)">
                    <option value="">Semua Kategori</option>
                    <option value="minuman"
                        {{ request('kategori') === 'minuman' ? 'selected' : '' }}>
                        Minuman
                    </option>
                    <option value="stok_barang"
                        {{ request('kategori') === 'stok_barang' ? 'selected' : '' }}>
                        Stok Barang
                    </option>
                </select>
            </form>

            <div id="resetBtn"
                 class="reset-btn"
                 onclick="resetFilter()">
                Reset
            </div>
        </div>
    </div>
 @if(Auth::user()->role === 'pemilik')
    <a href="{{ route('stok.export', ['kategori' => request('kategori')]) }}"
       class="text-btn">
        Export PDF
    </a>
    @endif
</div>

{{-- TABLE --}}
<div id="tableWrapper">

    <div id="loadingIndicator">
        <div class="spinner-border text-primary"></div>
    </div>

    <div class="table-wrapper table-responsive">
        <table class="table-modern">
            <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
            </thead>
            <tbody>
            @forelse($stok as $s)
            <tr>
                <td>{{ $s->nama }}</td>
                <td>{{ ucwords(str_replace('_',' ', $s->kategori)) }}</td>
                <td>{{ $s->stok }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

<script>
const btnFilter = document.getElementById("btnFilter");
const dropdown  = document.getElementById("filterDropdown");
const resetBtn  = document.getElementById("resetBtn");

btnFilter.onclick = () => dropdown.classList.toggle("show");

document.addEventListener("click", e => {
    if (!btnFilter.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove("show");
    }
});

function showLoading() {
    document.getElementById('tableWrapper').classList.add('loading');
    document.getElementById('loadingIndicator').style.display = 'flex';
}

function applyFilter(el) {
    showLoading();
    el.form.submit();
}

function resetFilter() {
    showLoading();
    window.location = "{{ route('stok.index') }}";
}

document.addEventListener('DOMContentLoaded', () => {
    if ("{{ request('kategori') }}") {
        resetBtn.style.display = 'block';
    }
});
</script>

</x-app-layout>
