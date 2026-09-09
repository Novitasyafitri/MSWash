<x-app-layout :title="'Pengeluaran'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body { font-family: 'Poppins', sans-serif !important; }

h4 {
    font-weight: 600;
    font-size: 22px;
    color: #111827;
}

/* =====================
   FILTER
===================== */
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
    outline: none;
}
.filter-date-input:focus {
    border-color: #93c5fd;
    box-shadow: none;
}

.reset-btn {
    margin-top: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #dc2626;
    cursor: pointer;
    display: none;
}
.reset-btn:hover { text-decoration: underline; }

.text-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #059669;
    text-decoration: none;
}

/* =====================
   TABLE + LOADING (SAMA PEMASUKAN)
===================== */
#tableWrapper {
    position: relative;
}

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

/* PRODUK STYLE */
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
}

.table-modern thead th {
    background: #5ca8ff;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 16px;
    border: none;
    text-align: left;
}

.table-modern thead th:first-child { border-top-left-radius: 16px; }
.table-modern thead th:last-child  { border-top-right-radius: 16px; }

.table-modern td {
    padding: 14px 16px;
    font-size: 14px;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
}

.table-modern tbody tr:hover td {
    background: #e5e7eb;   /* abu-abu halus */
    cursor: pointer;
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

    <h4 class="mb-3">Laporan Pengeluaran</h4>

    {{-- FILTER BAR --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="filter-wrapper ">
            <button class="btn-add-filter" id="btnFilter">
                <i class="bi bi-funnel"></i> Add Filter
            </button>

            <div class="filter-dropdown" id="filterDropdown">
                <form method="GET">
                    <input type="date"
                           name="tanggal"
                           class="filter-date-input"
                           value="{{ request('tanggal') }}"
                           oninput="delayFilter(this)">
                </form>

                <div id="resetBtn"
                     class="reset-btn"
                     onclick="resetFilter()">
                    Reset
                </div>
            </div>
        </div>

        {{-- EXPORT TANPA LOADING --}}
        @if(Auth::user()->role === 'pemilik')
        <a href="{{ route('pengeluaran.export', ['tanggal' => request('tanggal')]) }}"
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
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluarans as $p)
                    <tr>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ ucfirst($p->jenis) }}</td>
                        <td>
                            {{ $p->keterangan ?: ($p->nama_item ?: '-') }}
                        </td>
                        <td>Rp {{ number_format($p->total,0,',','.') }}</td>
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

    {{-- TOTAL --}}
     <h5 class="mt-3 fw-bold">
        Total:
        <span class="text-primary">
            Rp {{ number_format($totalPengeluaran,0,',','.') }}
        </span>
    </h5>
</div>

<script>

let filterTimer = null;

function delayFilter(el) {
    clearTimeout(filterTimer);

    filterTimer = setTimeout(() => {
        showLoading();
        dropdown.classList.remove('show');
        el.form.submit();
    }, 800); // tunggu user berhenti mengetik 0.5 detik
}

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
    dropdown.classList.remove('show');
    el.form.submit();
}

function resetFilter() {
    showLoading();
    dropdown.classList.remove('show');
    window.location = "{{ route('pengeluaran.index') }}";
}

document.addEventListener('DOMContentLoaded', () => {
    if ("{{ request('tanggal') }}") {
        resetBtn.style.display = 'block';
    }
});
</script>

</x-app-layout>
