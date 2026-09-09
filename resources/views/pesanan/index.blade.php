<x-app-layout :title="'Daftar Pesanan'">

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* =================================================
   FIX SCROLLBAR GERAK — FINAL
================================================= */
body {
    overflow-y: scroll !important;
    padding-right: 0 !important;
}
body.swal2-shown,
body.swal2-height-auto {
    padding-right: 0 !important;
    height: auto !important;
}
.swal2-container {
    overflow: hidden !important;
}

/* =================================================
   GLOBAL
================================================= */
body, table, button, input, h4 {
    font-family: "Poppins", sans-serif !important;
}

/* =================================================
   FILTER
================================================= */
.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #2563eb;
    cursor: pointer;
    margin-bottom: 10px;
}
.filter-box {
    width: 230px;
    background: #ffffff;
    border-radius: 14px;
    padding: 12px 14px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    display: none;
}
.filter-box input[type="date"] {
    width: 100%;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 14px;
    border: 1px solid #e5e7eb;
    outline: none;
}
.reset-btn {
    margin-top: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #dc2626;
    cursor: pointer;
    display: none;
}
tbody tr:hover td {
    background: #e5e7eb;   /* abu-abu halus */
    cursor: pointer;
}

/* =================================================
   TABLE + LOADING
================================================= */
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
    background: rgba(255,255,255,.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 14px;
}

table {
    width: 100%;
    margin-top: 16px;

    border-collapse: separate;
    border-spacing: 0;

    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;

    background: #ffffff;
}

thead {
    background: #5ca8ff;
    color: white;
}
th, td {
    padding: 12px 14px;
    font-size: 14px;
    font-weight: 400;        /* FIX */
    line-height: 1.6;
    color: #000000;           /* FIX */
}


td {
    border-bottom: 1px solid #eee;
}

.harga-badge {
    background: #e7f0ff;
    padding: 6px 14px;
    border-radius: 10px;
    font-weight: 600;
    color: #2563eb;
    font-size: 13px;
}
tbody td {
    color: #374151;   /* lebih lembut */
}

/* =========================
   ROUND TABLE CORNER
========================= */

/* HEADER */
thead th:first-child {
    border-top-left-radius: 14px;
}
thead th:last-child {
    border-top-right-radius: 14px;
}

/* FOOTER */
tbody tr:last-child td:first-child {
    border-bottom-left-radius: 14px;
}
tbody tr:last-child td:last-child {
    border-bottom-right-radius: 14px;
}
tbody tr:last-child td {
    border-bottom: none;
}
table {
    border: 1px solid #e5e7eb;    
    border-radius: 14px;
    overflow: hidden;
}

/* =================================================
   ACTION
================================================= */
.aksi-btn {
    background: #22c55e;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
}
.aksi-btn:hover {
    background: #16a34a;
}
thead th {
    font-weight: 600;
    color: #ffffff;
}


/* =================================================
   SWEETALERT
================================================= */
.swal-compact {
    border-radius: 14px !important;
}
.swal-title {
    font-size: 16px !important;
    font-weight: 600 !important;
}
.swal-btn {
    border-radius: 10px !important;
    padding: 6px 16px !important;
    font-size: 13px !important;
}
.swal-btn-cancel {
    background: #f3f4f6 !important;
    color: #374151 !important;
}
.table-responsive {
    width: 100%;
    overflow-x: auto; /* scroll horizontal jika tabel terlalu lebar */
    -webkit-overflow-scrolling: touch; /* smooth scroll di iOS */
}
.table-responsive table {
    min-width: 700px; /* sesuaikan minimal lebar tabel agar tidak pecah */
}
@media (max-width: 640px) {
     table th, table td {
        padding: 12px 14px;       /* sama kayak stok/layanan */
        font-size: 14px;           /* lebih mudah dibaca */
        white-space: nowrap;       /* jangan pecah ke baris baru */
        min-width: 90px;           /* minimal lebar standar */
    }
    .filter-box {
        width: 100%;
    }

    .filter-btn {
        font-size: 14px;     /* hampir sama kayak desktop, tapi compact */
    }

    .aksi-btn {
        padding: 6px 12px;
        font-size: 13px;
    }
    .container {
        margin-top: 8px !important;
    }

    /* Kecilkan Add Filter biar pas di HP */
    .filter-btn {
        font-size: 13px !important;
        padding: 4px 8px !important;
    }
    /* =======================================
   SCROLL HANYA TABEL — SOLUSI UTAMA
=======================================*/
.table-scroll-only {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
    overflow-x: auto;
    border-radius: 14px;
}

    table th:nth-child(2), table td:nth-child(2) { min-width: 140px; } /* Jenis */
    table th:nth-child(3), table td:nth-child(3) { min-width: 120px; } /* Kategori */
    table th:nth-child(4), table td:nth-child(4) { min-width: 110px; } /* Plat */
    table th:nth-child(5), table td:nth-child(5) { min-width: 120px; } /* Tanggal */
    table th:nth-child(6), table td:nth-child(6) { min-width: 120px; } /* Harga */
    table th:nth-child(7), table td:nth-child(7) { min-width: 100px; } /* Jumlah */
    table th:nth-child(8), table td:nth-child(8) { min-width: 110px; } /* Status */
    table th:nth-child(9), table td:nth-child(9) { min-width: 90px; }  /* Aksi */
    
}/* Hanya di HP (max-width 640px) */


</style>

<div class="container">

<h4 class="fw-bold mb-3">Daftar Transaksi</h4>

<!-- FILTER -->
<div class="filter-btn" onclick="toggleFilter()">
    <i class="bi bi-funnel"></i> Add Filter
</div>

<div id="filterBox" class="filter-box">
    <form method="GET">
       <input type="date"
       name="tanggal"
       value="{{ $tanggal }}"
       id="filterTanggal">
    </form>

    <div id="resetBtn"
         class="reset-btn"
         onclick="showLoading(); window.location='{{ route('pesanan.index') }}'">
        Reset
    </div>
</div>

<!-- TABLE -->
<div id="tableWrapper" class="table-responsive table-scroll-only">

    <!-- LOADING -->
    <div id="loadingIndicator">
        <div class="spinner-border text-primary"></div>
    </div>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Kategori</th>
            <th>Plat</th>
            <th>Tanggal</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Status</th>
            @if(Auth::user()->role === 'kasir')
                <th>Aksi</th>
            @endif
        </tr>
        </thead>

        <tbody>
        @foreach($pesanan as $i => $item)
        <tr id="row-{{ $item->id }}">
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->kategori }}</td>
            <td>{{ $item->plat ?? '-' }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>
                <span class="harga-badge">
                    Rp {{ number_format($item->harga,0,',','.') }}
                </span>
            </td>
            <td>{{ (int) $item->jumlah }}</td>
            <td class="status-text">
                {{ $item->status === 'siap' ? 'Sudah Siap' : 'Menunggu' }}
            </td>

            @if(Auth::user()->role === 'kasir')
            <td>
                @if($item->status !== 'siap')
                <button class="aksi-btn btn-confirm" aria-label="Konfirmasi Transaksi"
                        data-id="{{ $item->id }}">
                    <i class="bi bi-check2-circle"></i>
                </button>
                @else
                    <i class="bi bi-check-circle-fill text-success"></i>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
</div>

<script>
    window.addEventListener('pageshow', () => {
    const wrapper = document.getElementById('tableWrapper');
    const loading = document.getElementById('loadingIndicator');

    if (wrapper && loading) {
        wrapper.classList.remove('loading');
        loading.style.display = 'none';
    }
});
    let filterTimer = null;

document.getElementById('filterTanggal')?.addEventListener('change', function () {

    // hentikan timer sebelumnya
    if (filterTimer) {
        clearTimeout(filterTimer);
    }

    // kasih jeda biar user selesai pilih
    filterTimer = setTimeout(() => {
        showLoading();
        this.form.submit();
    }, 600); // ⏱ 600ms (bisa 500–800)
});
function toggleFilter() {
    const box = document.getElementById('filterBox');
    box.style.display = box.style.display === 'block' ? 'none' : 'block';
}

function showLoading() {
    document.getElementById('tableWrapper').classList.add('loading');
    document.getElementById('loadingIndicator').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {

    const tanggalHariIni = "{{ now()->toDateString() }}";
const tanggalAktif = "{{ $tanggal ?? '' }}".trim();

if (tanggalAktif !== '') {
    document.getElementById('resetBtn').style.display = 'block';
}


    document.querySelectorAll('.btn-confirm').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;

            Swal.fire({
                target: document.body,
                title: 'Pesanan siap?',
                text: 'Status akan diubah',
                icon: 'question',
                width: 320,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                scrollbarPadding: false,
                heightAuto: false,
                customClass: {
                    popup: 'swal-compact',
                    title: 'swal-title',
                    confirmButton: 'swal-btn',
                    cancelButton: 'swal-btn-cancel'
                }
            }).then(result => {
                if (result.isConfirmed) {
                    showLoading();

                    fetch(`/pesanan/${id}/siap`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(() => {
                        document.querySelector(`#row-${id} .status-text`)
                            .innerText = 'Sudah Siap';

                        btn.outerHTML = `
                            <i class="bi bi-check-circle-fill text-success"
                               style="font-size:18px"></i>
                        `;

                        document.getElementById('tableWrapper').classList.remove('loading');
                        document.getElementById('loadingIndicator').style.display = 'none';

                        Swal.fire({
                            target: document.body,
                            icon: 'success',
                            title: 'Berhasil',
                            width: 260,
                            timer: 900,
                            showConfirmButton: false,
                            scrollbarPadding: false,
                            heightAuto: false
                        });
                    });
                }
            });
        });
    });
});
</script>

</x-app-layout>
