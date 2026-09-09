<x-app-layout :title="'Data Karyawan'">

{{-- ================= FONT ================= --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* =========================
   PAGE TITLE
========================= */
h4 {
    font-weight: 600;
    font-size: 22px;
    color: #111827;
}

/* =========================
   CARD (SAMA PRODUK)
========================= */
.card-modern {
    border-radius: 16px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    padding: 20px;
}

/* =========================
   TABLE MODERN (SAMA PRODUK)
========================= */
.table-wrapper {
    border-radius: 16px;
    overflow: hidden;
}

.table-modern {
    border-collapse: separate !important;
    border-spacing: 0;
}

.table-modern thead th {
    background: color-mix(in srgb, #0d6efd 70%, white);
    color: #ffffff;
    border: none;
    padding: 12px 14px;
    font-size: 14px;
    font-weight: 600;
    vertical-align: middle;
}

.table-modern thead tr {
    box-shadow: inset 0 -1px 0 rgba(255,255,255,0.35);
}

.table-modern thead th:first-child {
    border-top-left-radius: 16px;
}
.table-modern thead th:last-child {
    border-top-right-radius: 16px;
}

.table-modern td {
    padding: 12px 14px;
    font-size: 14px;
    color: #111827;
    border-color: #e5e7eb;
    vertical-align: middle;
    text-align: center;
}

.table-modern tbody tr:hover td {
    background: #f3f7ff;
}

/* =========================
   ACTION BUTTON (SAMA PRODUK)
========================= */
.td-aksi {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.btn-action {
    border: none;
    background: #eef1f6;
    padding: 7px 10px;
    border-radius: 10px;
    transition: .2s ease-in-out;
}
.btn-action:hover {
    background: #d7dbe3;
    transform: translateY(-2px);
}

.btn-edit { color:#2563eb; }
.btn-warning { color:#f97316; }
.btn-success { color:#22c55e; }

/* =========================
   STATUS BADGE
========================= */
.badge-status {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 999px;
    color:white;
}
.badge-off { background:#6b7280; }
.badge-on { background:#2563eb; }

/* =========================
   PRIMARY BUTTON
========================= */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 500;
}

/* =========================
   SWEETALERT MINI STYLE
   (LOGIKA TIDAK DIUBAH)
========================= */
.swal2-popup {
    font-family: "Poppins", sans-serif !important;
    border-radius: 16px !important;
    width: 300px !important;
    padding: 16px 16px 14px !important;
}

.swal2-title {
    font-size: 16px !important;
    font-weight: 600 !important;
}

.swal2-html-container {
    font-size: 13px !important;
}

.swal2-icon {
    transform: scale(0.75);
    margin: 6px auto 10px !important;
}

.swal2-confirm,
.swal2-cancel {
    font-size: 13px !important;
    padding: 6px 14px !important;
    border-radius: 8px !important;
}

.swal2-confirm {
    background: #2563eb !important;
}
.fixed-alert-space {
    min-height: 0; /* ruang tetap agar tabel tidak turun */
}

.no-anim {
    transition: none !important; /* hentikan animasi muncul */
}

/* =========================
   RESPONSIVE KHUSUS HP
========================= */
@media (max-width: 768px) {

    /* Judul turun sedikit */
    h4 {
        margin-top: 20px;
        font-size: 20px;
    }

    /* Lebarkan area agar tabel tidak terlihat sempit */
    .container {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    /* Card normal tidak dikecilkan */
    .card-modern {
        padding: 16px;
    }

    /* Kolom tetap nyaman dibaca */
    .table-modern thead th {
        font-size: 14px;
        padding: 12px 10px;
        white-space: nowrap;
    }

    .table-modern td {
        font-size: 14px;
        padding: 12px 10px;
        white-space: nowrap;
    }

    /* Tombol aksi tetap normal */
    .btn-action {
        padding: 7px 10px;
        border-radius: 10px;
    }

    /* Table scroll biar kolom tidak dipaksa mengecil */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    h4 {
        margin-top: 30px !important;
    }
}

</style>

<div class="container pt-4">

    <h4 class="mb-3">Data Karyawan</h4>

    @if(Auth::user()->role === 'pemilik')
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">
            + Tambah Karyawan
        </a>
    @endif
    <div class="fixed-alert-space">
@if(session('success'))
<script>
Swal.fire({
    icon: "success",
    title: "Berhasil",
    text: `{!! session('success') !!}`,
    timer: 1500,
    showConfirmButton: false,
    heightAuto: false,
    scrollbarPadding: false,
    backdrop: `
        rgba(0,0,0,0.25)
        blur(3px)
    `
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: "error",
    title: "Gagal",
    text: `{!! session('error') !!}`,
    timer: 2200,
    showConfirmButton: false,
    heightAuto: false,
    scrollbarPadding: false,
    backdrop: `
        rgba(0,0,0,0.35)
        blur(3px)
    `
});
</script>
@endif
</div>

    <div class="card-modern table-wrapper">
         <div class="table-responsive">
        <table class="table table-hover mb-0 table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Umur</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($karyawan as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ ucfirst($k->jabatan) }}</td>
                    <td>
    @if($k->jabatan === 'kasir')
        {{ $k->user?->email ?? '-' }}
    @else
        -
    @endif
</td>
                    <td>{{ $k->umur }} th</td>
                    <td>{{ $k->tanggal_masuk }}</td>

<td>
    @if(Auth::user()->role === 'pemilik')
        @if($k->status === 'aktif')
            <span class="badge-status badge-on">Aktif</span>
        @else
            <span class="badge-status badge-off">Nonaktif</span>
        @endif
    @else
        -
    @endif
</td>


<td class="td-aksi">
    @if(Auth::user()->role === 'pemilik')

        <a href="{{ route('karyawan.edit',$k->id) }}"
           class="btn-action btn-edit">
            <i class="bi bi-pencil-square"></i>
        </a>

        @if($k->status === 'aktif')
            <form method="POST"
                  action="{{ route('karyawan.nonaktifKaryawan',$k->id) }}"
                  class="d-inline form-nonaktif">
                @csrf
                <button class="btn-action btn-warning">
                    <i class="bi bi-person-slash"></i>
                </button>
            </form>
        @else
            <form method="POST"
                  action="{{ route('karyawan.aktifkanKaryawan',$k->id) }}"
                  class="d-inline form-aktif">
                @csrf
                <button class="btn-action btn-success">
                    <i class="bi bi-person-check"></i>
                </button>
            </form>
        @endif

    @else
        -
    @endif
</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

{{-- =====================
   SWEETALERT CONFIRM
===================== --}}
<script>
document.querySelectorAll('.form-nonaktif').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: 'Nonaktifkan akun?',
            text: 'Akun tidak bisa login setelah dinonaktifkan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Nonaktifkan',
            cancelButtonText: 'Batal',
            heightAuto: false,
            scrollbarPadding: false,
            backdrop: `
                rgba(0,0,0,0.35)
                blur(4px)
            `
        }).then(res => {
            if (res.isConfirmed) form.submit();
        });
    });
});

document.querySelectorAll('.form-aktif').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: 'Aktifkan akun?',
            text: 'Akun bisa login kembali',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aktifkan',
            cancelButtonText: 'Batal',
            heightAuto: false,
            scrollbarPadding: false,
            backdrop: `
                rgba(0,0,0,0.35)
                blur(4px)
            `
        }).then(res => {
            if (res.isConfirmed) form.submit();
        });
    });
});
</script>
</x-app-layout>
