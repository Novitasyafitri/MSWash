<x-app-layout title="Laporan Bagi Hasil">

{{-- ================= FONT ================= --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* ================= TITLE ================= */
.page-title {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
    margin-top: 0;
}

/* ================= TABLE WRAPPER (SAMA PEMASUKAN) ================= */
.table-wrapper {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* ================= TABLE ================= */
.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

/* HEADER */
.table-modern thead th {
    background: #5ca8ff;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    padding: 14px 16px;
    text-align: left;
}

.table-modern thead th:first-child {
    border-top-left-radius: 16px;
}
.table-modern thead th:last-child {
    border-top-right-radius: 16px;
}

/* BODY */
.table-modern tbody td {
    padding: 10px 14px;
    font-size: 14px;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.table-modern tbody tr:hover td {
    background: #e5e7eb;;
}

/* ALIGN */
.text-center {
    text-align: center;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-aktif {
    background: #dcfce7;
    color: #166534;
}

.badge-selesai {
    background: #f1f5f9;
    color: #475569;
}

/* PDF LINK */
.pdf-link {
    color: #dc2626;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
}

.pdf-link:hover {
    border-bottom: 2px solid #dc2626;
    padding-bottom: 2px;
}

.pdf-link i {
    font-size: 15px;
}
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
    background: rgba(255,255,255,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 16px;
}
.filter-dropdown {
    position: absolute;
    top: 100%;          /* ⬅️ tepat di bawah tombol */
    left: 0;
    margin-top: 6px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    border-radius: 14px;
    padding: 12px;
    width: 220px;
    display: none;
    z-index: 50;
}
.filter-dropdown.show {
    display: block;
}

.filter-date-input {
    width: 100%;
    padding: 8px 10px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

.reset-btn {
    font-size: 13px;
    color: #dc2626;
    cursor: pointer;
    font-weight: 600;
}

.reset-btn:hover {
    text-decoration: underline;
}
h4 {
    font-weight: 600;
    font-size: 22px;
    color: #111827;
}
#btnFilter {
    margin-top: 6px;      /* ⬅️ turunin dikit */
    color: #2563eb;       /* ⬅️ samain biru */
    font-weight: 500;
}
/* ================= RESPONSIVE ================= */

/* Tablet (≤ 900px) */
@media (max-width: 900px) {

    .container {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }

    .table-modern thead th {
        font-size: 13px;
        padding: 12px 14px;
    }

    .table-modern tbody td {
        font-size: 13px;
        padding: 10px 12px;
    }

    .pdf-link {
        font-size: 12px;
    }
}

/* HP (≤ 600px) */
@media (max-width: 600px) {

    /* Table scroll */
    .table-wrapper {
        overflow-x: auto;
    }

    .table-modern th,
    .table-modern td {
        white-space: nowrap; /* biar tidak numpuk */
        font-size: 13px;
    }

    .page-title,
    h4 {
        font-size: 18px !important;
    }

    /* Badge */
    .badge {
        font-size: 11px;
        padding: 4px 10px;
    }

    /* Periode text */
    td div {
        line-height: 1.2;
    }

    /* Filter button */
    #btnFilter {
        font-size: 14px;
    }

    /* Dropdown filter biar tidak keluar layar */
    .filter-dropdown {
        width: 180px;
        right: 0;
    }
}

/* HP kecil (≤ 450px) */
@media (max-width: 450px) {

    .table-modern th:first-child,
    .table-modern td:first-child {
        width: 40px !important;
    }

    .pdf-link i {
        font-size: 13px !important;
    }

    .pdf-link {
        font-size: 12px !important;
    }
}
/* RESPONSIVE FIX UTAMA */
@media (max-width: 768px) {
    .container {
        max-width: 100% !important;
        padding-left: 14px !important;
        padding-right: 14px !important;
    }

    .table-wrapper {
        width: 100% !important;
        overflow-x: auto;
    }
}
/* BIKIN KOLOM LEBIH PROPORSIONAL DI HP */
@media (max-width: 600px) {
    .table-modern th:nth-child(1),
    .table-modern td:nth-child(1) {
        min-width: 50px;
    }
    .table-modern th:nth-child(2),
    .table-modern td:nth-child(2) {
        min-width: 150px;
        white-space: normal; /* ⬅️ Periode bisa turun ke bawah */
    }
    .table-modern th:nth-child(3),
    .table-modern td:nth-child(3),
    .table-modern th:nth-child(4),
    .table-modern td:nth-child(4) {
        min-width: 90px;
        text-align: center;
    }
    h4 {
        margin-top: 40px !important;
    }
}
.filter-wrapper {
    position: relative;
    display: inline-block;
}
</style>

{{-- ================= PAGE ================= --}}
<div class="container pt-3" style="max-width:1100px">
    <h4 class="mb-3">Laporan Bagi Hasil</h4>

<div class="filter-wrapper">

    {{-- ADD FILTER --}}
    <button type="button"
            id="btnFilter"
            class="btn btn-link text-decoration-none p-0 d-flex align-items-center gap-1">
        <i class="bi bi-funnel"></i>
        Add Filter
    </button>

    {{-- DROPDOWN FILTER --}}
    <div id="filterDropdown" class="filter-dropdown">
        <form method="GET">

            <input type="month"
                   name="periode"
                   class="filter-date-input"
                   value="{{ request('periode') ?? now()->format('Y-m') }}"
                   onchange="showLoading(); this.form.submit()">

            @if(request('periode'))
                <div class="reset-btn mt-2" onclick="resetFilter()">
                    Reset
                </div>
            @endif

        </form>
    </div>

</div>

<div id="tableWrapper">

    {{-- LOADING --}}
    <div id="loadingIndicator">
        <div class="spinner-border text-primary"></div>
    </div>

    <div class="table-wrapper">
        <table class="table-modern">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Tanggal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($periodes as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>

                <td>
                    <div style="font-weight:500; line-height:1.2">
                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}
                    </div>
                    <div style="font-size:11px;color:#6b7280; line-height:1.2">
                        sampai
                        {{ $p->tanggal_selesai
                            ? \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y')
                            : 'Sekarang' }}
                    </div>
                </td>

                <td class="text-center">
                    @if($p->status === 'aktif')
                        <span class="badge badge-aktif">Aktif</span>
                    @else
                        <span class="badge badge-selesai">Selesai</span>
                    @endif
                </td>

                <td class="text-center">
                    <a href="{{ route('bagi-hasil.pdf', $p->id) }}"
                       target="_blank"
                       class="pdf-link">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                        PDF
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    Belum ada laporan
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>
</div>
<script>
const btnFilter = document.getElementById('btnFilter');
const dropdown  = document.getElementById('filterDropdown');

btnFilter.addEventListener('click', e => {
    e.preventDefault();
    dropdown.classList.toggle('show');
});

document.addEventListener('click', e => {
    if (!btnFilter.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});

function resetFilter() {
    showLoading();
    window.location = "{{ route('bagi-hasil.laporan') }}";
}
function showLoading() {
    const wrapper = document.getElementById('tableWrapper');
    const loader  = document.getElementById('loadingIndicator');

    if (wrapper && loader) {
        wrapper.classList.add('loading');
        loader.style.display = 'flex';
    }
}
</script>

</x-app-layout>
